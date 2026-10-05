<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.school_name') }} — Student Information System</title>
    <meta name="description" content="{{ config('app.school_name') }} Student Information System — enrollments, grades, requirements, and billing in one place.">
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
    <section class="welcome-hero">
        <img class="bg" src="{{ asset('2.png') }}" alt="Campus background">
        <div class="inner">
            <span class="badge mb-3" style="background:rgba(59,130,246,.2);color:#93C5FD;">Academic Portal</span>
            <h1 class="display-5 fw-bold text-white">{{ config('app.school_name') }}</h1>
            <p class="lead mt-3" style="color:#CBD5E1;">Student Information System — enrollments, grades, requirements, and billing in one place.</p>
            <div class="mt-4 d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Log in</a>
                @auth('web')
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-lg px-4">Dashboard</a>
                @elseauth('student')
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-light btn-lg px-4">Student Portal</a>
                @endauth
            </div>
            <p class="mt-4 small" style="color:var(--text-3);"><i class="bi bi-geo-alt"></i> {{ config('app.school_location') }}</p>
        </div>
    </section>
</body>

</html>
