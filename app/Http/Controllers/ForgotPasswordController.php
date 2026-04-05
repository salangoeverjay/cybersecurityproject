<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use App\Support\PasswordSecurity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use InvalidArgumentException;

class ForgotPasswordController extends Controller
{
    public function showForgotForm(): View
    {
        return view('auth.forgot-password', ['title' => 'Forgot Password']);
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
        ]);

        $user = User::where('username', $validated['username'])->first();
        if (!$user) {
            return back()->withInput()->with('error', 'Username does not exist.');
        }

        try {
            $rawToken = bin2hex(random_bytes(32));
        } catch (\Throwable $exception) {
            return back()->withInput()->with('error', 'Unable to generate reset token. Please try again.');
        }

        try {
            $tokenHash = PasswordSecurity::hashResetToken($rawToken);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        PasswordResetToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token_hash' => $tokenHash,
                'expires_at' => Carbon::now()->addMinutes((int) config('security.password_reset_ttl_minutes', 15)),
            ]
        );

        // Use relative URL to avoid incorrect host issues behind proxies (e.g. Railway).
        $resetLink = route('password.reset.form', ['token' => $rawToken], false);

        return back()
            ->with('success', 'Password reset link generated successfully.')
            ->with('reset_link', $resetLink);
    }

    public function showResetForm(string $token): View
    {
        $resolvedUsername = '';

        try {
            $incomingTokenHash = PasswordSecurity::hashResetToken($token);
            $resetRecord = PasswordResetToken::where('token_hash', $incomingTokenHash)->first();

            if ($resetRecord && Carbon::now()->lessThanOrEqualTo($resetRecord->expires_at)) {
                $user = User::find($resetRecord->user_id);
                $resolvedUsername = (string) ($user?->username ?? '');
            }
        } catch (\Throwable $exception) {
            $resolvedUsername = '';
        }

        return view('auth.reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'username' => $resolvedUsername,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        try {
            $incomingTokenHash = PasswordSecurity::hashResetToken($validated['token']);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        $resetRecord = PasswordResetToken::where('token_hash', $incomingTokenHash)->first();
        if (!$resetRecord || Carbon::now()->greaterThan($resetRecord->expires_at)) {
            return back()->withInput()->with('error', 'Invalid or expired reset link.');
        }

        $user = User::find($resetRecord->user_id);
        if (!$user) {
            return back()->withInput()->with('error', 'Invalid or expired reset link.');
        }

        try {
            $newSalt = PasswordSecurity::generateSalt();
            $newPasswordHash = PasswordSecurity::hash($validated['password'], $newSalt);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        $user->update([
            'salt' => $newSalt,
            'password_hash' => $newPasswordHash,
        ]);

        $resetRecord->delete();

        return redirect()->route('login.form')->with('success', 'Password reset successful. Please login.');
    }
}
