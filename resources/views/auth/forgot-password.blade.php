@extends('layouts.app')

@section('content')
    <p class="subtitle">Generate a secure reset link (local demo flow).</p>

    <form method="POST" action="{{ route('password.forgot.submit') }}">
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

        <button type="submit">Generate Reset Link</button>
    </form>

    @if(session('reset_link'))
        <div class="alert alert-success" style="margin-top: 12px;">
            Reset link (local demo): <a href="{{ session('reset_link') }}">{{ session('reset_link') }}</a>
        </div>
    @endif

    <p class="helper">
        Back to login? <a href="{{ route('login.form') }}">Login here</a>
    </p>
@endsection
