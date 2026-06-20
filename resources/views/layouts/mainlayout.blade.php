<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-dark">
    <div class="container-scroller">
        <nav class="navbar navbar-expand-lg bg-black text-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-white" href="/dashboard">SIS Admin</a>
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
                    <li class="nav-item my-2"><a class="nav-link text-white" href="/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="/students"><i class="bi bi-person-lines-fill"></i> Student List</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="/subjects"><i class="bi bi-book"></i> Subject List</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('interviews.index') }}"><i class="bi bi-calendar-event"></i> Interview Calendar</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('admin.requirements.index') }}"><i class="bi bi-file-earmark-check"></i> Requirements Review</a></li>
                    <li class="nav-item my-2 mt-3"><small class="text-muted px-3">MODULES</small></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.students.index') }}"><i class="bi bi-people"></i> Student Profiles</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.academic-history') }}"><i class="bi bi-mortarboard"></i> Academic History</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.admissions') }}"><i class="bi bi-person-plus"></i> Admissions</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.scheduling') }}"><i class="bi bi-clock"></i> Scheduling</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.attendance') }}"><i class="bi bi-check2-square"></i> Attendance</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.billing') }}"><i class="bi bi-cash-coin"></i> Billing & Fees</a></li>
                    <li class="nav-item my-2"><a class="nav-link text-white" href="{{ route('modules.reports') }}"><i class="bi bi-bar-chart"></i> Reports</a></li>
                    <li class="nav-item my-2 mt-3"><a class="nav-link text-white" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle"></i> Edit Profile</a></li>
                </ul>
            </nav>

            <div class="content container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
