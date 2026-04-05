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
        <div class="stat downloads-stat">
            <strong>Downloads:</strong>
            <span class="stat-value">
                <span class="download-links">
                    <a
                        class="download-link download-link-doc"
                        href="https://docs.google.com/document/d/1P8e9xV9Z6oKPiVMz5eV3ZE71mYb21H6JL_o1pbzBxHg/export?format=pdf"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <span class="download-icon">DOC</span>
                        <span class="download-label">Project Documentation</span>
                        <span class="download-type">PDF</span>
                    </a>
                    <a
                        class="download-link download-link-source"
                        href="https://github.com/salangoeverjay/cybersecurityproject/archive/refs/heads/main.zip"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <span class="download-icon">SRC</span>
                        <span class="download-label">Source Code</span>
                        <span class="download-type">ZIP</span>
                    </a>
                </span>
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

    <style>
        .downloads-stat .stat-value {
            flex-basis: 100%;
        }

        .download-links {
            display: grid;
            gap: 10px;
            width: 100%;
            margin-top: 2px;
        }

        .download-link {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            text-decoration: none;
            color: #d8ffef;
            border-radius: 12px;
            border: 1px solid rgba(55, 255, 176, 0.28);
            background: linear-gradient(135deg, rgba(9, 37, 30, 0.92), rgba(7, 26, 38, 0.9));
            padding: 10px 12px;
            transition: transform .16s ease, border-color .16s ease, box-shadow .16s ease, background .16s ease;
        }

        .download-link:hover {
            transform: translateY(-1px);
            border-color: rgba(55, 255, 176, 0.62);
            box-shadow: 0 10px 22px rgba(5, 199, 152, 0.22);
            background: linear-gradient(135deg, rgba(12, 45, 36, 0.97), rgba(8, 31, 45, 0.96));
        }

        .download-link:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(55, 255, 176, 0.24);
            border-color: rgba(55, 255, 176, 0.8);
        }

        .download-icon {
            flex: 0 0 auto;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            font-family: "Share Tech Mono", monospace;
            color: #d9fff2;
            border: 1px solid rgba(55, 255, 176, 0.3);
            background: rgba(7, 55, 44, 0.62);
        }

        .download-label {
            flex: 1 1 auto;
            min-width: 0;
            font-weight: 600;
            font-size: 13px;
            line-height: 1.25;
            color: #d8ffef;
            overflow-wrap: anywhere;
        }

        .download-type {
            flex: 0 0 auto;
            padding: 3px 7px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #b5ffe2;
            border: 1px solid rgba(31, 221, 255, 0.36);
            background: rgba(0, 55, 66, 0.58);
            font-family: "Share Tech Mono", monospace;
        }

        .download-link-doc .download-type {
            border-color: rgba(55, 255, 176, 0.45);
            background: rgba(9, 66, 45, 0.52);
        }

        .download-link-source .download-type {
            border-color: rgba(31, 221, 255, 0.44);
            background: rgba(0, 43, 63, 0.56);
        }
    </style>
@endsection
