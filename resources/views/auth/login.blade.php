@extends('layouts.app')

@section('content')
    <p class="subtitle">Authenticate to the secure node and validate encrypted credentials.</p>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="field">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                placeholder="Enter your username"
                required
            >
        </div>

        <div class="field">
            <label for="password">Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >
                <button
                    type="button"
                    class="password-toggle"
                    data-toggle-password="password"
                    data-visible="false"
                    aria-label="Show password"
                    title="Show password"
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

        <button type="submit">Initialize Session</button>
    </form>

    <p class="helper">
        No access profile yet? <a href="{{ route('register.form') }}">Create operator ID</a>
    </p>
    <p class="helper">
        Lost your keyphrase? <a href="{{ route('password.forgot.form') }}">Run password reset</a>
    </p>
@endsection
