@extends('layouts.app')

@section('content')
    <p class="subtitle">Secure tunnel online. Authentication handshake completed.</p>

    <div class="dash-grid">
        <div class="stat">
            <strong>Node Status:</strong>
            <span class="stat-value">Access Granted</span>
        </div>
        <div class="stat">
            <strong>Operator ID:</strong>
            <span class="stat-value">{{ $username }}</span>
        </div>
        <div class="stat">
            <strong>Crypto Layer:</strong>
            <span class="stat-value">Salted + peppered SHA-256 verification passed</span>
        </div>
        <div class="stat">
            <strong>Password Hash:</strong>
            <span class="stat-value">{{ $passwordHash }}</span>
        </div>
        <div class="stat">
            <strong>Salt:</strong>
            <span class="stat-value">{{ $salt }}</span>
        </div>
        <div class="stat">
            <strong>Downloads:</strong>
            <span class="stat-value">
                <a href="https://docs.google.com/document/d/1P8e9xV9Z6oKPiVMz5eV3ZE71mYb21H6JL_o1pbzBxHg/export?format=pdf" target="_blank" rel="noopener noreferrer">Download Documentation (PDF)</a><br>
                <a href="https://github.com/salangoeverjay/cybersecurityproject/archive/refs/heads/main.zip" target="_blank" rel="noopener noreferrer">Download Source Code (ZIP)</a>
            </span>
        </div>
    </div>

    <p class="helper">
        Need to rotate credentials? <a href="{{ route('settings.form') }}">Open control panel</a>
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="ghost-btn">Terminate Session</button>
    </form>
@endsection
