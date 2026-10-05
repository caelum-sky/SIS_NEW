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
</body>

</html>
