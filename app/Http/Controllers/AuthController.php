<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register', ['title' => 'User Registration']);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        $pepper = config('security.password_pepper');
        if (empty($pepper)) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        // Security: generate a cryptographically secure random salt for each user.
        $salt = bin2hex(random_bytes(16));
        $passwordHash = $this->hashPasswordWithSaltAndPepper($validated['password'], $salt, $pepper);

        User::create([
            'username' => $validated['username'],
            'password_hash' => $passwordHash,
            'salt' => $salt,
        ]);

        return redirect()->route('login.form')->with('success', 'Registration Successful. Please login.');
    }

    public function showLogin(): View
    {
        return view('auth.login', ['title' => 'User Login']);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:100'],
        ]);

        $pepper = config('security.password_pepper');
        if (empty($pepper)) {
            return back()->withInput()->with('error', 'Server configuration error: missing PASSWORD_PEPPER.');
        }

        $user = User::where('username', $validated['username'])->first();
        if (!$user) {
            return back()->withInput()->with('error', 'Invalid Username or Password');
        }

        $computedHash = $this->hashPasswordWithSaltAndPepper($validated['password'], $user->salt, $pepper);

        // Security: use hash_equals to reduce timing attack risk.
        if (!hash_equals($user->password_hash, $computedHash)) {
            return back()->withInput()->with('error', 'Invalid Username or Password');
        }

        // Security: regenerate session ID after successful login.
        $request->session()->regenerate();
        $request->session()->put('auth_user_id', $user->id);
        $request->session()->put('auth_username', $user->username);

        return redirect()->route('dashboard')->with('success', 'Login Successful');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('auth_user_id')) {
            return redirect()->route('login.form')->with('error', 'Please login first.');
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'username' => $request->session()->get('auth_username'),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['auth_user_id', 'auth_username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'You have been logged out.');
    }

    /**
     * Hashes password + salt + pepper using SHA-256.
     */
    private function hashPasswordWithSaltAndPepper(string $password, string $salt, string $pepper): string
    {
        return hash('sha256', $password.$salt.$pepper);
    }
}
