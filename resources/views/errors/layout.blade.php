<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — @yield('title_text', 'Error') | {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; background: linear-gradient(135deg, #070B14, #0F172A); color: #CBD5E1; display: flex; min-height: 100vh; align-items: center; justify-content: center; margin: 0; }
        .box { text-align: center; padding: 2rem; }
        .code { font-size: 4.5rem; font-weight: 800; margin: 0; background: linear-gradient(135deg, #3B82F6, #22D3EE); -webkit-background-clip: text; background-clip: text; color: transparent; }
        h1 { color: #F8FAFC; margin: .5rem 0; }
        a { display: inline-block; margin-top: 1.25rem; padding: .55rem 1.4rem; border-radius: 10px; background: rgba(59,130,246,.15); border: 1px solid rgba(59,130,246,.4); color: #93C5FD; text-decoration: none; font-weight: 600; }
        a:hover { background: rgba(59,130,246,.28); }
    </style>
</head>
<body>
    <div class="box">
        <p class="code">@yield('code')</p>
        <h1>@yield('title_text')</h1>
        <p>@yield('message')</p>
        <a href="{{ url('/') }}">Back to home</a>
    </div>
</body>
</html>
