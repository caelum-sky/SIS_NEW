<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-dark">

    <div class="container-scroller">
        <nav class="navbar navbar-expand-lg bg-black text-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-white" href="/dashboard">@yield('title')</a>
                <div class="d-flex align-items-center">
                    <h5 class="me-3 m-0">Hello, {{ auth()->user()->name }}</h5>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <nav class="sidebar bg-black text-white p-3" style="width: 250px; min-height: 100vh;">
                <ul class="nav flex-column">
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="/students">
                            <i class="bi bi-person-lines-fill"></i> Student List
                        </a>
                    </li>
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="/subjects">
                            <i class="bi bi-book"></i> Subject List
                        </a>
                    </li>
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i> Edit Profile
                        </a>
                    </li>
                </ul>
            </nav>

        <!-- Page Content -->
        <div class="content container-fluid p-4">
            {{ $slot }}
            </div>
        </div>
    </div>

</body>
