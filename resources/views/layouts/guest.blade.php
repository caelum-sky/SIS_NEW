<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} — Portal</title>
    @include('partials.seo')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function () {
            var mode = localStorage.getItem('theme') || 'device';
            function resolved(m) {
                if (m === 'light' || m === 'dark') return m;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', resolved(mode));
            window.setTheme = function (m) {
                localStorage.setItem('theme', m);
                document.documentElement.setAttribute('data-theme', resolved(m));
            };
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
                if ((localStorage.getItem('theme') || 'device') === 'device') {
                    document.documentElement.setAttribute('data-theme', resolved('device'));
                }
            });
        })();
    </script>
</head>

<body>
    <div class="auth-shell">
        <div class="auth-visual">
            <img src="{{ asset('2.png') }}" alt="Campus night lab">
            <div class="auth-caption">
                <h1 class="h2 fw-bold text-white">{{ config('app.school_name') }}</h1>
                <p class="mb-0" style="color:#CBD5E1;">Student Information System — enrollments, grades, requirements and billing in one secure portal.</p>
            </div>
        </div>
        <div class="auth-form-pane">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </div>
    <div class="dropdown" style="position:fixed;bottom:1rem;right:1rem;z-index:50;">
        <button class="icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Theme"><i class="bi bi-brightness-half"></i></button>
        <ul class="dropdown-menu dropdown-menu-end" style="background:var(--surface-2);border:1px solid var(--border-soft);border-radius:12px;">
            <li><a class="dropdown-item" href="#" onclick="setTheme('light');return false;" style="color:var(--text-2);"><i class="bi bi-sun"></i> Light</a></li>
            <li><a class="dropdown-item" href="#" onclick="setTheme('dark');return false;" style="color:var(--text-2);"><i class="bi bi-moon-stars"></i> Dark</a></li>
            <li><a class="dropdown-item" href="#" onclick="setTheme('device');return false;" style="color:var(--text-2);"><i class="bi bi-display"></i> Device</a></li>
        </ul>
    </div>
</body>

</html>
