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

        try {
            $rawToken = bin2hex(random_bytes(32));
        } catch (\Throwable $exception) {
            return back()->withInput()->with('error', 'Unable to generate reset token. Please try again.');
        }

        if ($user) {
            try {
                $tokenHash = PasswordSecurity::hashResetToken($rawToken);
            } catch (InvalidArgumentException $exception) {
                return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
            }

            PasswordResetToken::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'token_hash' => $tokenHash,
                    'expires_at' => Carbon::now()->addMinutes(15),
                ]
            );
        }

        // Demo-friendly flow: always show a link after submit.
        // Only valid usernames can complete reset because token hash is stored only when user exists.
        // Use relative URL to avoid incorrect host issues behind proxies (e.g. Railway).
        $resetLink = route('password.reset.form', ['token' => $rawToken, 'username' => $validated['username']], false);

        return back()
            ->with('success', 'If that username exists, a password reset link has been generated.')
            ->with('reset_link', $resetLink);
    }

    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'username' => (string) $request->query('username', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        $user = User::where('username', $validated['username'])->first();
        if (!$user) {
            return back()->withInput()->with('error', 'Invalid or expired reset link.');
        }

        $resetRecord = PasswordResetToken::where('user_id', $user->id)->first();
        if (!$resetRecord || Carbon::now()->greaterThan($resetRecord->expires_at)) {
            return back()->withInput()->with('error', 'Invalid or expired reset link.');
        }

        try {
            $incomingTokenHash = PasswordSecurity::hashResetToken($validated['token']);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        if (!hash_equals($resetRecord->token_hash, $incomingTokenHash)) {
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
