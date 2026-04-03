@extends('layouts.app')

@section('content')
    <p class="subtitle">Manage your account details securely.</p>

    <div class="dash-grid">
        <div class="stat"><strong>Current Username:</strong> {{ $username }}</div>
    </div>

    <form method="POST" action="{{ route('settings.username.update') }}">
        @csrf
        <div class="field">
            <label for="new_username">New Username</label>
            <input
                type="text"
                id="new_username"
                name="new_username"
                value="{{ old('new_username', $username) }}"
                placeholder="New username"
                required
            >
        </div>

        <div class="field">
            <label for="current_password_for_username">Current Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="current_password_for_username"
                    name="current_password_for_username"
                    placeholder="Enter current password"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="current_password_for_username"
                    data-visible="false"
                    aria-label="Show current password"
                    title="Show current password"
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

        <button type="submit">Update Username</button>
    </form>

    <form method="POST" action="{{ route('settings.password.update') }}" style="margin-top: 18px;">
        @csrf
        <div class="field">
            <label for="current_password">Current Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    placeholder="Enter current password"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="current_password"
                    data-visible="false"
                    aria-label="Show current password"
                    title="Show current password"
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
            <label for="new_password">New Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    placeholder="Minimum 8 characters"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="new_password"
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
            <label for="new_password_confirmation">Confirm New Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    placeholder="Retype new password"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="new_password_confirmation"
                    data-visible="false"
                    aria-label="Show new password confirmation"
                    title="Show new password confirmation"
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

        <button type="submit">Update Password</button>
    </form>

    <p class="helper">
        Back to dashboard? <a href="{{ route('dashboard') }}">Go to dashboard</a>
    </p>
@endsection
