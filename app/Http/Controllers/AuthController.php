<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\PasswordSecurity;
use InvalidArgumentException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register', ['title' => 'Operator Provisioning']);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        try {
            $salt = PasswordSecurity::generateSalt();
            $passwordHash = PasswordSecurity::hash($validated['password'], $salt);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        User::create([
            'username' => $validated['username'],
            'password_hash' => $passwordHash,
            'salt' => $salt,
        ]);

        return redirect()->route('login.form')->with('success', 'Access profile created. Authenticate to continue.');
    }

    public function showLogin(): View
    {
        return view('auth.login', ['title' => 'Secure Login Gateway']);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:100'],
        ]);

        $user = User::where('username', $validated['username'])->first();
        if (!$user) {
            return back()->withInput()->with('error', 'Invalid Username or Password');
        }

        try {
            $validPassword = PasswordSecurity::verify($validated['password'], $user->salt, $user->password_hash);
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        if (!$validPassword) {
            return back()->withInput()->with('error', 'Invalid Username or Password');
        }

        // Security: regenerate session ID after successful login.
        $request->session()->regenerate();
        $request->session()->put('auth_user_id', $user->id);
        $request->session()->put('auth_username', $user->username);

        return redirect()->route('dashboard')->with('success', 'Secure session initialized.');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('auth_user_id')) {
            return redirect()->route('login.form')->with('error', 'Please login first.');
        }

        return view('dashboard', [
            'title' => 'Mission Dashboard',
            'username' => $request->session()->get('auth_username'),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['auth_user_id', 'auth_username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Session terminated successfully.');
    }
}
