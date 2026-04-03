<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cybersecurity Auth Project' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Rajdhani:wght@500;600;700&family=Share+Tech+Mono&display=swap');

        :root {
            --panel: rgba(2, 21, 17, 0.84);
            --panel-border: rgba(60, 255, 169, 0.44);
            --text-main: #cbffeb;
            --text-soft: #8dc7b4;
            --brand: #37ffb0;
            --brand-strong: #8effd5;
            --accent: #1fddff;
            --danger-bg: rgba(74, 17, 37, 0.62);
            --danger-text: #ffa8c2;
            --success-bg: rgba(16, 81, 52, 0.56);
            --success-text: #a2ffd0;
            --ring: rgba(55, 255, 176, 0.24);
            --shadow: 0 30px 80px rgba(0, 0, 0, 0.58), 0 0 24px rgba(31, 221, 255, 0.2);
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
                radial-gradient(
                    circle at 50% 44%,
                    rgba(55, 255, 176, 0.17) 0%,
                    rgba(55, 255, 176, 0.06) 20%,
                    transparent 52%
                ),
                radial-gradient(
                    circle at 20% 16%,
                    rgba(31, 221, 255, 0.19) 0%,
                    transparent 36%
                ),
                radial-gradient(
                    circle at 78% 84%,
                    rgba(41, 255, 145, 0.14) 0%,
                    transparent 30%
                ),
                linear-gradient(145deg, #010706, #000402 56%, #020909);
            display: grid;
            place-items: center;
            padding: 22px;
            position: relative;
            isolation: isolate;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            pointer-events: none;
        }

        body::before {
            inset: -30px;
            z-index: -3;
            background:
                repeating-linear-gradient(
                    90deg,
                    rgba(57, 255, 179, 0.08) 0 1px,
                    transparent 1px 56px
                ),
                repeating-linear-gradient(
                    0deg,
                    rgba(57, 255, 179, 0.06) 0 1px,
                    transparent 1px 48px
                );
            opacity: 0.42;
        }

        body::after {
            width: 560px;
            height: 560px;
            border-radius: 999px;
            left: 50%;
            top: 50%;
            z-index: -2;
            background:
                radial-gradient(
                    circle,
                    rgba(55, 255, 176, 0.3) 0%,
                    rgba(31, 221, 255, 0.16) 44%,
                    transparent 72%
                );
            filter: blur(14px);
            opacity: 0.7;
            transform: translate(-50%, -50%);
        }

        .particle-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            opacity: 1;
        }

        .panel {
            width: min(520px, 100%);
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 30px 28px;
            animation: cardIn 560ms cubic-bezier(.2,.7,.1,1) both;
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .panel::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(
                    180deg,
                    rgba(255, 255, 255, 0.04),
                    rgba(255, 255, 255, 0.01) 45%,
                    rgba(255, 255, 255, 0.06)
                ),
                repeating-linear-gradient(
                    0deg,
                    rgba(55, 255, 176, 0.06) 0 1px,
                    transparent 1px 5px
                );
            opacity: 0.45;
            z-index: -1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #a4ffdb;
            background: rgba(9, 33, 28, 0.86);
            border: 1px solid rgba(55, 255, 176, 0.34);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 14px;
            font-family: "Share Tech Mono", monospace;
        }

        h1 {
            margin: 0 0 22px;
            font-family: "Rajdhani", sans-serif;
            font-size: clamp(28px, 4.4vw, 34px);
            line-height: 1.1;
            letter-spacing: -0.02em;
            text-transform: uppercase;
            color: #d8ffef;
            text-shadow: 0 0 18px rgba(55, 255, 176, 0.2);
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
            color: #95f7cc;
            font-size: 14px;
            font-family: "Share Tech Mono", monospace;
            letter-spacing: 0.03em;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            border: 1px solid rgba(55, 255, 176, 0.22);
            border-radius: var(--radius-md);
            padding: 12px 13px;
            font: inherit;
            font-size: 15px;
            background: rgba(2, 15, 13, 0.82);
            color: var(--text-main);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
            font-family: "Share Tech Mono", monospace;
        }

        input::placeholder { color: #6fa58f; }

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
            border: 1px solid rgba(55, 255, 176, 0.28);
            background: rgba(4, 26, 21, 0.94);
            color: #97ffd4;
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
            background: rgba(8, 37, 30, 0.97);
            border-color: rgba(55, 255, 176, 0.52);
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
            color: #002718;
            background: linear-gradient(135deg, var(--brand), #00f5d4 65%, var(--accent));
            box-shadow: 0 10px 28px rgba(31, 221, 255, 0.23);
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
            animation: rise 560ms ease-out both;
            animation-delay: 350ms;
            font-family: "Share Tech Mono", monospace;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(31, 221, 255, 0.3);
            filter: saturate(1.05);
        }

        .ghost-btn {
            margin-top: 10px;
            background: rgba(9, 33, 28, 0.85);
            color: var(--brand);
            border: 1px solid rgba(55, 255, 176, 0.28);
            box-shadow: none;
        }

        .ghost-btn:hover {
            box-shadow: none;
            background: rgba(11, 43, 35, 0.95);
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
            background: rgba(8, 35, 29, 0.74);
            border: 1px solid rgba(55, 255, 176, 0.2);
            font-size: 14px;
            color: #b8f8df;
            font-family: "Share Tech Mono", monospace;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(14px) scale(0.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            body { padding: 14px; }
            body::after {
                width: 420px;
                height: 420px;
            }
            .panel { padding: 24px 18px; border-radius: 18px; }
            h1 { font-size: 28px; }
        }

    </style>
</head>
<body>
    <canvas id="particle-canvas" class="particle-canvas" aria-hidden="true"></canvas>
    <div class="panel">
        <div class="eyebrow">Cyber Ops Access Grid</div>
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

        (function () {
            var canvas = document.getElementById('particle-canvas');
            var ctx = canvas ? canvas.getContext('2d') : null;

            if (!canvas || !ctx) {
                return;
            }

            var reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            var reducedMotion = reduceMotionQuery.matches;

            var pointer = {
                x: 0,
                y: 0,
                active: false,
            };
            var particles = [];
            var width = 0;
            var height = 0;
            var dpr = 1;
            var animationFrameId = null;
            var lineDistance = 118;
            var pointerRadius = 130;

            function clamp(value, min, max) {
                return Math.min(max, Math.max(min, value));
            }

            function particleCountForViewport() {
                var byArea = Math.floor((width * height) / 12000);
                return clamp(byArea, reducedMotion ? 44 : 90, reducedMotion ? 110 : 220);
            }

            function randomBetween(min, max) {
                return Math.random() * (max - min) + min;
            }

            function createParticle() {
                return {
                    x: randomBetween(0, width),
                    y: randomBetween(0, height),
                    vx: randomBetween(reducedMotion ? -0.2 : -0.45, reducedMotion ? 0.2 : 0.45),
                    vy: randomBetween(reducedMotion ? -0.2 : -0.45, reducedMotion ? 0.2 : 0.45),
                    size: randomBetween(0.9, 2.1),
                };
            }

            function resetParticles() {
                particles = [];
                var count = particleCountForViewport();

                for (var i = 0; i < count; i += 1) {
                    particles.push(createParticle());
                }
            }

            function resizeCanvas() {
                width = window.innerWidth;
                height = window.innerHeight;
                dpr = Math.min(window.devicePixelRatio || 1, 2);
                canvas.width = Math.floor(width * dpr);
                canvas.height = Math.floor(height * dpr);
                canvas.style.width = width + 'px';
                canvas.style.height = height + 'px';
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                lineDistance = clamp(Math.min(width, height) * 0.16, 96, 148);
                pointerRadius = clamp(Math.min(width, height) * 0.16, 92, 150);
                if (reducedMotion) {
                    lineDistance *= 0.86;
                    pointerRadius *= 0.72;
                }
                resetParticles();
            }

            function updateParticle(particle) {
                particle.vx += randomBetween(-0.015, 0.015);
                particle.vy += randomBetween(-0.015, 0.015);

                if (pointer.active) {
                    var dx = particle.x - pointer.x;
                    var dy = particle.y - pointer.y;
                    var distSq = dx * dx + dy * dy;
                    var radiusSq = pointerRadius * pointerRadius;

                    if (distSq < radiusSq) {
                        var distance = Math.sqrt(distSq) || 0.001;
                        var force = (pointerRadius - distance) / pointerRadius;
                        var pushForce = reducedMotion ? 0.08 : 0.24;
                        particle.vx += (dx / distance) * force * pushForce;
                        particle.vy += (dy / distance) * force * pushForce;
                    }
                }

                particle.vx = clamp(particle.vx, -1.25, 1.25);
                particle.vy = clamp(particle.vy, -1.25, 1.25);
                particle.vx *= reducedMotion ? 0.99 : 0.986;
                particle.vy *= reducedMotion ? 0.99 : 0.986;

                particle.x += particle.vx;
                particle.y += particle.vy;

                if (particle.x <= 0 || particle.x >= width) {
                    particle.vx *= -1;
                    particle.x = clamp(particle.x, 0, width);
                }

                if (particle.y <= 0 || particle.y >= height) {
                    particle.vy *= -1;
                    particle.y = clamp(particle.y, 0, height);
                }
            }

            function drawFrame() {
                ctx.clearRect(0, 0, width, height);

                for (var i = 0; i < particles.length; i += 1) {
                    var p = particles[i];
                    updateParticle(p);

                    for (var j = i + 1; j < particles.length; j += 1) {
                        var q = particles[j];
                        var dx = p.x - q.x;
                        var dy = p.y - q.y;
                        var dist = Math.sqrt(dx * dx + dy * dy);

                        if (dist < lineDistance) {
                            var alpha = (1 - dist / lineDistance) * (reducedMotion ? 0.2 : 0.46);
                            ctx.strokeStyle = 'rgba(53, 255, 204, ' + alpha.toFixed(3) + ')';
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(p.x, p.y);
                            ctx.lineTo(q.x, q.y);
                            ctx.stroke();
                        }
                    }

                    if (pointer.active) {
                        var pdx = p.x - pointer.x;
                        var pdy = p.y - pointer.y;
                        var pdist = Math.sqrt(pdx * pdx + pdy * pdy);

                        if (pdist < pointerRadius * 0.88) {
                            var pAlpha = (1 - pdist / (pointerRadius * 0.88)) * (reducedMotion ? 0.25 : 0.62);
                            ctx.strokeStyle = 'rgba(0, 193, 255, ' + pAlpha.toFixed(3) + ')';
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(p.x, p.y);
                            ctx.lineTo(pointer.x, pointer.y);
                            ctx.stroke();
                        }
                    }

                    ctx.fillStyle = reducedMotion ? 'rgba(126, 255, 224, 0.72)' : 'rgba(126, 255, 224, 0.95)';
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fill();
                }

                animationFrameId = window.requestAnimationFrame(drawFrame);
            }

            window.addEventListener('pointermove', function (event) {
                pointer.x = event.clientX;
                pointer.y = event.clientY;
                pointer.active = true;
            }, { passive: true });

            window.addEventListener('mousemove', function (event) {
                pointer.x = event.clientX;
                pointer.y = event.clientY;
                pointer.active = true;
            }, { passive: true });

            window.addEventListener('pointerleave', function () {
                pointer.active = false;
            });

            window.addEventListener('pointerup', function () {
                pointer.active = false;
            });

            window.addEventListener('pointercancel', function () {
                pointer.active = false;
            });

            window.addEventListener('pointerout', function (event) {
                if (!event.relatedTarget) {
                    pointer.active = false;
                }
            });

            window.addEventListener('blur', function () {
                pointer.active = false;
            });

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
            animationFrameId = window.requestAnimationFrame(drawFrame);

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    if (animationFrameId !== null) {
                        window.cancelAnimationFrame(animationFrameId);
                        animationFrameId = null;
                    }
                    return;
                }

                if (animationFrameId === null) {
                    animationFrameId = window.requestAnimationFrame(drawFrame);
                }
            });
        })();
    </script>
</body>
</html>
