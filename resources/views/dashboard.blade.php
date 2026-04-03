@extends('layouts.app')

@section('content')
    <p class="subtitle">Secure tunnel online. Authentication handshake completed.</p>

    <div class="dash-grid">
        <div class="stat"><strong>Node Status:</strong> Access Granted</div>
        <div class="stat"><strong>Operator ID:</strong> {{ $username }}</div>
        <div class="stat"><strong>Crypto Layer:</strong> Salted + peppered SHA-256 verification passed</div>
    </div>

    <p class="helper">
        Need to rotate credentials? <a href="{{ route('settings.form') }}">Open control panel</a>
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="ghost-btn">Terminate Session</button>
    </form>
@endsection
