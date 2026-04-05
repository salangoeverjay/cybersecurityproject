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
        <div class="reset-link-card" style="margin-top: 12px;">
            <p class="reset-link-title">Password Reset Link Ready</p>
            <p class="reset-link-subtitle">Use this link to continue resetting the password.</p>
            <code class="reset-link-url" id="reset-link-url">{{ session('reset_link') }}</code>
            <div class="reset-link-actions">
                <a
                    href="{{ session('reset_link') }}"
                    class="reset-link-action"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Open Link
                </a>
                <button
                    type="button"
                    class="reset-link-action reset-link-copy"
                    data-copy-reset-link
                >
                    Copy Link
                </button>
            </div>
            <p class="reset-link-copy-feedback" data-copy-feedback hidden>Link copied.</p>
        </div>
    @endif

    <p class="helper">
        Back to login? <a href="{{ route('login.form') }}">Login here</a>
    </p>

    <style>
        .reset-link-card {
            border-radius: 14px;
            border: 1px solid rgba(55, 255, 176, 0.32);
            background: linear-gradient(140deg, rgba(8, 44, 34, 0.9), rgba(4, 30, 47, 0.88));
            padding: 12px;
        }

        .reset-link-title {
            margin: 0;
            font-family: "Share Tech Mono", monospace;
            font-size: 13px;
            letter-spacing: 0.04em;
            color: #c6ffe8;
            text-transform: uppercase;
        }

        .reset-link-subtitle {
            margin: 6px 0 10px;
            color: #8fd9bc;
            font-size: 13px;
        }

        .reset-link-url {
            display: block;
            margin: 0;
            width: 100%;
            padding: 9px 10px;
            border-radius: 10px;
            border: 1px solid rgba(55, 255, 176, 0.24);
            background: rgba(2, 17, 14, 0.88);
            color: #aefedd;
            font-size: 12px;
            line-height: 1.45;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-wrap;
            user-select: all;
        }

        .reset-link-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .reset-link-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 35px;
            padding: 8px 11px;
            border-radius: 10px;
            border: 1px solid rgba(55, 255, 176, 0.34);
            background: rgba(8, 34, 27, 0.88);
            color: #d7ffee;
            font-family: "Share Tech Mono", monospace;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: background .16s ease, border-color .16s ease, transform .16s ease;
        }

        .reset-link-action:hover {
            background: rgba(12, 48, 38, 0.93);
            border-color: rgba(55, 255, 176, 0.6);
            transform: translateY(-1px);
        }

        .reset-link-action:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(55, 255, 176, 0.24);
        }

        .reset-link-copy-feedback {
            margin: 9px 2px 0;
            color: #9efbd0;
            font-size: 12px;
            font-family: "Share Tech Mono", monospace;
        }
    </style>

    <script>
        (function () {
            var copyButton = document.querySelector('[data-copy-reset-link]');
            var linkElement = document.getElementById('reset-link-url');
            var feedback = document.querySelector('[data-copy-feedback]');

            if (!copyButton || !linkElement || !feedback) {
                return;
            }

            copyButton.addEventListener('click', function () {
                var linkText = linkElement.textContent || '';
                if (!linkText) {
                    return;
                }

                navigator.clipboard.writeText(linkText).then(function () {
                    feedback.hidden = false;
                    window.setTimeout(function () {
                        feedback.hidden = true;
                    }, 1800);
                });
            });
        })();
    </script>
@endsection
