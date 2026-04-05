@extends('layouts.app')

@section('content')
    <p class="subtitle">Provision a new operator account with hardened password hashing defenses.</p>

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="field">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                placeholder="e.g. cyber_student01"
                autocomplete="username"
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
                    placeholder="Minimum 8 characters"
                    autocomplete="new-password"
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
            <div class="password-strength" id="password-strength" data-tone="none">
                <div
                    class="password-strength-track"
                    id="password-strength-track"
                    role="progressbar"
                    aria-label="Password strength"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="0"
                >
                    <span class="password-strength-fill" id="password-strength-fill"></span>
                </div>
                <p class="password-strength-text" id="password-strength-text">Strength: Not entered</p>
                <div class="password-strength-rules">
                    <span class="password-rule" data-rule="length">At least 8 characters</span>
                    <span class="password-rule" data-rule="mixed">Uppercase + lowercase letters</span>
                    <span class="password-rule" data-rule="number">At least 1 number</span>
                    <span class="password-rule" data-rule="symbol">At least 1 symbol</span>
                </div>
            </div>
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm Password</label>
            <div class="password-wrap">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Retype your password"
                    autocomplete="new-password"
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

        <button type="submit">Create Access Profile</button>
    </form>

    <p class="helper">
        Existing operator? <a href="{{ route('login.form') }}">Enter login gateway</a>
    </p>

    <style>
        .password-strength {
            margin-top: 10px;
        }

        .password-strength-track {
            width: 100%;
            height: 9px;
            border-radius: 999px;
            border: 1px solid rgba(55, 255, 176, 0.26);
            background: rgba(2, 18, 15, 0.92);
            overflow: hidden;
        }

        .password-strength-fill {
            display: block;
            width: 0%;
            height: 100%;
            border-radius: inherit;
            transition: width 180ms ease, background 180ms ease;
            background: linear-gradient(90deg, #4d5855, #73827d);
        }

        .password-strength-text {
            margin: 8px 2px 0;
            font-size: 12px;
            font-family: "Share Tech Mono", monospace;
            color: #91aa9f;
            letter-spacing: 0.02em;
        }

        .password-strength-rules {
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
            margin-top: 9px;
        }

        .password-rule {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #78a896;
            font-family: "Share Tech Mono", monospace;
        }

        .password-rule::before {
            content: "○";
            color: #608777;
            line-height: 1;
        }

        .password-rule.met {
            color: #adffd8;
        }

        .password-rule.met::before {
            content: "●";
            color: #37ffb0;
            text-shadow: 0 0 8px rgba(55, 255, 176, 0.5);
        }

        .password-strength[data-tone="weak"] .password-strength-fill {
            background: linear-gradient(90deg, #ff6f86, #ff9a6b);
        }

        .password-strength[data-tone="medium"] .password-strength-fill {
            background: linear-gradient(90deg, #ffb83f, #ffe55a);
        }

        .password-strength[data-tone="strong"] .password-strength-fill {
            background: linear-gradient(90deg, #12e9a3, #2ff5ff);
        }

        .password-strength[data-tone="weak"] .password-strength-text {
            color: #ff9ab3;
        }

        .password-strength[data-tone="medium"] .password-strength-text {
            color: #ffe482;
        }

        .password-strength[data-tone="strong"] .password-strength-text {
            color: #a6ffd8;
        }
    </style>

    <script>
        (function () {
            var passwordInput = document.getElementById('password');
            var meter = document.getElementById('password-strength');
            var fill = document.getElementById('password-strength-fill');
            var meterTrack = document.getElementById('password-strength-track');
            var text = document.getElementById('password-strength-text');
            var ruleLength = meter ? meter.querySelector('[data-rule="length"]') : null;
            var ruleMixed = meter ? meter.querySelector('[data-rule="mixed"]') : null;
            var ruleNumber = meter ? meter.querySelector('[data-rule="number"]') : null;
            var ruleSymbol = meter ? meter.querySelector('[data-rule="symbol"]') : null;

            if (!passwordInput || !meter || !fill || !meterTrack || !text) {
                return;
            }

            function evaluatePassword(password) {
                var hasLength = password.length >= 8;
                var hasLower = /[a-z]/.test(password);
                var hasUpper = /[A-Z]/.test(password);
                var hasNumber = /\d/.test(password);
                var hasSymbol = /[^A-Za-z0-9]/.test(password);
                var hasMixed = hasLower && hasUpper;
                var bonusLength = password.length >= 12 ? 1 : 0;
                var score = 0;

                if (hasLength) {
                    score += 1;
                }
                if (hasLower) {
                    score += 1;
                }
                if (hasUpper) {
                    score += 1;
                }
                if (hasNumber) {
                    score += 1;
                }
                if (hasSymbol) {
                    score += 1;
                }
                score += bonusLength;

                var percent = Math.round((score / 6) * 100);
                var tone = 'weak';
                var label = 'Weak';

                if (password.length === 0) {
                    return {
                        percent: 0,
                        tone: 'none',
                        label: 'Not entered',
                        rules: {
                            length: hasLength,
                            mixed: hasMixed,
                            number: hasNumber,
                            symbol: hasSymbol,
                        },
                    };
                }

                if (!hasLength || score <= 2) {
                    tone = 'weak';
                    label = 'Weak';
                } else if (score <= 4) {
                    tone = 'medium';
                    label = 'Medium';
                } else {
                    tone = 'strong';
                    label = 'Strong';
                }

                return {
                    percent: percent,
                    tone: tone,
                    label: label,
                    rules: {
                        length: hasLength,
                        mixed: hasMixed,
                        number: hasNumber,
                        symbol: hasSymbol,
                    },
                };
            }

            function updateRuleState(element, met) {
                if (!element) {
                    return;
                }

                element.classList.toggle('met', met);
            }

            function renderStrength() {
                var result = evaluatePassword(passwordInput.value);
                meter.setAttribute('data-tone', result.tone);
                fill.style.width = result.percent + '%';
                meterTrack.setAttribute('aria-valuenow', String(result.percent));
                text.textContent = 'Strength: ' + result.label;

                updateRuleState(ruleLength, result.rules.length);
                updateRuleState(ruleMixed, result.rules.mixed);
                updateRuleState(ruleNumber, result.rules.number);
                updateRuleState(ruleSymbol, result.rules.symbol);
            }

            passwordInput.addEventListener('input', renderStrength);
            renderStrength();
        })();
    </script>
@endsection
