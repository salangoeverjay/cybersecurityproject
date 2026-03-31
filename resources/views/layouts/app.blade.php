<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cybersecurity Auth Project' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap');

        :root {
            --bg-1: #f7f9fc;
            --bg-2: #e8f3ff;
            --panel: rgba(255, 255, 255, 0.74);
            --panel-border: rgba(255, 255, 255, 0.9);
            --text-main: #0d1b2a;
            --text-soft: #4d6073;
            --brand: #006dff;
            --brand-strong: #0055cb;
            --accent: #00b7d6;
            --danger-bg: #fff0ee;
            --danger-text: #9e2f23;
            --success-bg: #ebfff3;
            --success-text: #1d6c39;
            --ring: rgba(0, 109, 255, 0.28);
            --shadow: 0 25px 55px rgba(7, 25, 60, 0.14);
            --radius-xl: 24px;
            --radius-md: 12px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "IBM Plex Sans", "Segoe UI", sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 8% 18%, #dff5ff 0%, transparent 35%),
                radial-gradient(circle at 94% 8%, #dff0ff 0%, transparent 30%),
                linear-gradient(145deg, var(--bg-1), var(--bg-2));
            display: grid;
            place-items: center;
            padding: 22px;
            position: relative;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 999px;
            z-index: -1;
            filter: blur(3px);
        }

        body::before {
            width: 320px;
            height: 320px;
            left: -90px;
            bottom: -120px;
            background: linear-gradient(120deg, rgba(0, 183, 214, 0.2), rgba(0, 109, 255, 0.2));
            animation: driftA 13s ease-in-out infinite;
        }

        body::after {
            width: 220px;
            height: 220px;
            right: -60px;
            top: 90px;
            background: linear-gradient(120deg, rgba(0, 109, 255, 0.15), rgba(0, 183, 214, 0.18));
            animation: driftB 11s ease-in-out infinite;
        }

        .panel {
            width: min(520px, 100%);
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 30px 28px;
            animation: cardIn 560ms cubic-bezier(.2,.7,.1,1) both;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #0b4a85;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(0, 109, 255, 0.14);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        h1 {
            margin: 0 0 22px;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(28px, 4.4vw, 34px);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .subtitle {
            margin: -10px 0 18px;
            color: var(--text-soft);
            font-size: 15px;
        }

        .field {
            margin-bottom: 14px;
            animation: rise 520ms ease-out both;
        }

        .field:nth-child(1) { animation-delay: 120ms; }
        .field:nth-child(2) { animation-delay: 200ms; }
        .field:nth-child(3) { animation-delay: 280ms; }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #15365a;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            border: 1px solid rgba(12, 66, 122, 0.22);
            border-radius: var(--radius-md);
            padding: 12px 13px;
            font: inherit;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.97);
            color: var(--text-main);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        input::placeholder { color: #88a0b8; }

        input:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--ring);
            transform: translateY(-1px);
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 54px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 9px;
            transform: translateY(-50%);
            width: 42px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(12, 66, 122, 0.18);
            background: rgba(255, 255, 255, 0.96);
            color: #2f5b87;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            line-height: 1;
            box-shadow: none;
            animation: none;
            transition: background .2s ease, border-color .2s ease, transform .2s ease;
        }

        .password-toggle:hover {
            transform: translateY(-50%);
            background: #fff;
            border-color: rgba(0, 109, 255, 0.32);
            box-shadow: none;
            filter: none;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .password-toggle .icon-hide {
            display: none;
        }

        .password-toggle[data-visible="true"] .icon-show {
            display: none;
        }

        .password-toggle[data-visible="true"] .icon-hide {
            display: inline;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 12px 15px;
            font: inherit;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--brand), #0088ff 65%, var(--accent));
            box-shadow: 0 12px 26px rgba(0, 109, 255, 0.28);
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
            animation: rise 560ms ease-out both;
            animation-delay: 350ms;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 28px rgba(0, 109, 255, 0.32);
            filter: saturate(1.05);
        }

        .ghost-btn {
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.84);
            color: var(--brand);
            border: 1px solid rgba(0, 109, 255, 0.22);
            box-shadow: none;
        }

        .ghost-btn:hover {
            box-shadow: none;
            background: rgba(255, 255, 255, 1);
        }

        .alert {
            border-radius: 13px;
            padding: 11px 13px;
            margin-bottom: 12px;
            font-size: 14px;
            border: 1px solid transparent;
            animation: rise 420ms ease-out both;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: rgba(26, 128, 67, 0.2);
        }

        .alert-error {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-color: rgba(160, 62, 49, 0.18);
        }

        .errors ul { margin: 0; padding-left: 18px; }

        .helper {
            margin: 14px 2px 0;
            font-size: 14px;
            color: var(--text-soft);
        }

        .helper a {
            color: var(--brand-strong);
            text-decoration: none;
            font-weight: 600;
        }

        .helper a:hover { text-decoration: underline; }

        .dash-grid {
            display: grid;
            gap: 12px;
            margin-bottom: 10px;
            animation: rise 520ms ease-out both;
            animation-delay: 120ms;
        }

        .stat {
            border-radius: 14px;
            padding: 13px 14px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(0, 109, 255, 0.16);
            font-size: 14px;
            color: #173f68;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(14px) scale(0.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes driftA {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(14px, -12px); }
        }

        @keyframes driftB {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-10px, 10px); }
        }

        @media (max-width: 640px) {
            body { padding: 14px; }
            .panel { padding: 24px 18px; border-radius: 18px; }
            h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="eyebrow">Cybersecurity Project</div>
        <h1>{{ $title ?? 'Authentication' }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                var targetId = button.getAttribute('data-toggle-password');
                var input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                var showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';
                button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                button.setAttribute('title', showing ? 'Show password' : 'Hide password');
                button.setAttribute('data-visible', showing ? 'false' : 'true');
            });
        });
    </script>
</body>
</html>
