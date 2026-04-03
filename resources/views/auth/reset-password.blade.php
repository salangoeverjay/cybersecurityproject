@extends('layouts.app')

@section('content')
    <p class="subtitle">Set your new password securely.</p>

    <form method="POST" action="{{ route('password.reset.submit') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $username) }}"
                placeholder="Enter your username"
                required
            >
        </div>

        <div class="field">
            <label for="password">New Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimum 8 characters"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="password"
                    data-visible="false"
                    aria-label="Show new password"
                    title="Show new password"
                >
                    <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.6a3 3 0 1 0 4.24 4.24"></path>
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a17.2 17.2 0 0 1-4 4.9"></path>
                        <path d="M6.1 6.1A17.7 17.7 0 0 0 2 12s3.5 7 10 7c1.4 0 2.6-.3 3.8-.7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm New Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Retype new password"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="password_confirmation"
                    data-visible="false"
                    aria-label="Show password confirmation"
                    title="Show password confirmation"
                >
                    <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.6a3 3 0 1 0 4.24 4.24"></path>
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a17.2 17.2 0 0 1-4 4.9"></path>
                        <path d="M6.1 6.1A17.7 17.7 0 0 0 2 12s3.5 7 10 7c1.4 0 2.6-.3 3.8-.7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit">Reset Password</button>
    </form>

    <p class="helper">
        Back to login? <a href="{{ route('login.form') }}">Login here</a>
    </p>
@endsection
