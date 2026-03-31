@extends('layouts.app')

@section('content')
    <p class="subtitle">Session established and credentials verified.</p>

    <div class="dash-grid">
        <div class="stat"><strong>Status:</strong> Login Successful</div>
        <div class="stat"><strong>Signed in as:</strong> {{ $username }}</div>
        <div class="stat"><strong>Security:</strong> Salted + peppered SHA-256 hash validation complete</div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="ghost-btn">Logout</button>
    </form>
@endsection
