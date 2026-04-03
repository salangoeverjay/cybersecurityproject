<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use App\Support\PasswordSecurity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;

class SettingsController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $user = User::find($request->session()->get('auth_user_id'));
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Please login again.');
        }

        return view('settings', [
            'title' => 'Account Settings',
            'username' => $user->username,
        ]);
    }

    public function updateUsername(Request $request): RedirectResponse
    {
        $user = User::find($request->session()->get('auth_user_id'));
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Please login again.');
        }

        $validated = $request->validate([
            'new_username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'current_password_for_username' => ['required', 'string', 'max:100'],
        ]);

        try {
            $validCurrentPassword = PasswordSecurity::verify(
                $validated['current_password_for_username'],
                $user->salt,
                $user->password_hash
            );
        } catch (InvalidArgumentException $exception) {
            return back()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        if (!$validCurrentPassword) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['username' => $validated['new_username']]);
        $request->session()->put('auth_username', $validated['new_username']);

        return back()->with('success', 'Username updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = User::find($request->session()->get('auth_user_id'));
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Please login again.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'max:100'],
            'new_password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        try {
            $validCurrentPassword = PasswordSecurity::verify(
                $validated['current_password'],
                $user->salt,
                $user->password_hash
            );
        } catch (InvalidArgumentException $exception) {
            return back()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        if (!$validCurrentPassword) {
            return back()->with('error', 'Current password is incorrect.');
        }

        try {
            $newSalt = PasswordSecurity::generateSalt();
            $newPasswordHash = PasswordSecurity::hash($validated['new_password'], $newSalt);
        } catch (InvalidArgumentException $exception) {
            return back()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        $user->update([
            'salt' => $newSalt,
            'password_hash' => $newPasswordHash,
        ]);

        PasswordResetToken::where('user_id', $user->id)->delete();

        return back()->with('success', 'Password updated successfully.');
    }
}
