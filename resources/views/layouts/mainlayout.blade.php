<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @include('partials.seo')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="app-shell">
        <aside class="app-sidebar" id="appSidebar">
            <a href="{{ route('dashboard') }}" class="brand">
                <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                <span>
                    <span class="brand-name">{{ config('app.school_name') }}</span><br>
                    <span class="brand-sub">Admin Portal</span>
                </span>
            </a>

            <div class="nav-section">Main</div>
            <nav class="app-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Students</a>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}"><i class="bi bi-book"></i> Subjects</a>
                <a href="{{ route('interviews.index') }}" class="{{ request()->routeIs('interviews.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Interviews</a>
                <a href="{{ route('admin.requirements.index') }}" class="{{ request()->routeIs('admin.requirements.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-check"></i> Requirements</a>
            </nav>

            <div class="nav-section">Modules</div>
            <nav class="app-nav">
                <a href="{{ route('modules.students.index') }}" class="{{ request()->routeIs('modules.students*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i> Student Profiles</a>
                <a href="{{ route('modules.academic-history') }}" class="{{ request()->routeIs('modules.academic-history') ? 'active' : '' }}"><i class="bi bi-mortarboard"></i> Academic History</a>
                <a href="{{ route('modules.admissions') }}" class="{{ request()->routeIs('modules.admissions') ? 'active' : '' }}"><i class="bi bi-person-plus"></i> Admissions</a>
                <a href="{{ route('modules.scheduling') }}" class="{{ request()->routeIs('modules.scheduling') ? 'active' : '' }}"><i class="bi bi-clock"></i> Scheduling</a>
                <a href="{{ route('modules.attendance') }}" class="{{ request()->routeIs('modules.attendance') ? 'active' : '' }}"><i class="bi bi-check2-square"></i> Attendance</a>
                <a href="{{ route('modules.billing') }}" class="{{ request()->routeIs('modules.billing') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i> Billing &amp; Fees</a>
                <a href="{{ route('modules.reports') }}" class="{{ request()->routeIs('modules.reports') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i> Reports</a>
            </nav>

            <div class="sidebar-foot">
                <nav class="app-nav">
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-100 text-start" style="background:none;border:none;padding:.55rem .75rem;border-radius:10px;color:var(--text-3);font-weight:500;font-size:.9rem;display:flex;align-items:center;gap:.7rem;">
                            <i class="bi bi-box-arrow-right" style="width:20px;text-align:center;"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <div class="app-main">
            <header class="app-topbar">
                <button class="icon-btn mobile-nav-toggle" id="sidebarToggle" aria-label="Toggle navigation"><i class="bi bi-list"></i></button>
                <h1 class="h6 m-0 d-none d-md-block" style="color:var(--text-1);font-weight:700;">@yield('title')</h1>
                <div class="topbar-search">
                    <i class="bi bi-search"></i>
                    <input type="search" placeholder="Search students, subjects, reports..." aria-label="Search">
                </div>
                <div class="topbar-actions">
                    <button class="icon-btn" aria-label="Notifications"><i class="bi bi-bell"></i></button>
                    <div class="user-chip">
                        <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="d-none d-sm-block">
                            <span class="name">{{ auth()->user()->name }}</span><br>
                            <span class="role">Administrator</span>
                        </span>
                    </div>
                </div>
            </header>

            <main class="app-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            var toggle = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('appSidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            function close() { sidebar.classList.remove('open'); backdrop.classList.remove('open'); }
            if (toggle) toggle.addEventListener('click', function () {
                sidebar.classList.toggle('open'); backdrop.classList.toggle('open');
            });
            if (backdrop) backdrop.addEventListener('click', close);
        })();
    </script>
    @stack('scripts')
</body>

</html>
