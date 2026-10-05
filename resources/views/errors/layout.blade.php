<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — @yield('title_text', 'Error') | {{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #111; color: #eee; display: flex; min-height: 100vh; align-items: center; justify-content: center; margin: 0; }
        .box { text-align: center; padding: 2rem; }
        .code { font-size: 4rem; font-weight: 800; margin: 0; color: #0d6efd; }
        a { color: #6ea8fe; }
    </style>
</head>
<body>
    <div class="box">
        <p class="code">@yield('code')</p>
        <h1>@yield('title_text')</h1>
        <p>@yield('message')</p>
        <p><a href="{{ url('/') }}">Back to home</a></p>
    </div>
</body>
</html>
