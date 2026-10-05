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
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" data-title="Dashboard"><i class="bi bi-grid-1x2"></i> <span>Dashboard</span></a>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}" data-title="Students"><i class="bi bi-people"></i> <span>Students</span></a>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}" data-title="Subjects"><i class="bi bi-book"></i> <span>Subjects</span></a>
                <a href="{{ route('interviews.index') }}" class="{{ request()->routeIs('interviews.*') ? 'active' : '' }}" data-title="Interviews"><i class="bi bi-calendar-event"></i> <span>Interviews</span></a>
                <a href="{{ route('admin.requirements.index') }}" class="{{ request()->routeIs('admin.requirements.*') ? 'active' : '' }}" data-title="Requirements"><i class="bi bi-file-earmark-check"></i> <span>Requirements</span></a>
            </nav>

            <div class="nav-section">Modules</div>
            <nav class="app-nav">
                <a href="{{ route('modules.students.index') }}" class="{{ request()->routeIs('modules.students*') ? 'active' : '' }}" data-title="Student Profiles"><i class="bi bi-person-badge"></i> <span>Student Profiles</span></a>
                <a href="{{ route('modules.academic-history') }}" class="{{ request()->routeIs('modules.academic-history') ? 'active' : '' }}" data-title="Academic History"><i class="bi bi-mortarboard"></i> <span>Academic History</span></a>
                <a href="{{ route('modules.admissions') }}" class="{{ request()->routeIs('modules.admissions') ? 'active' : '' }}" data-title="Admissions"><i class="bi bi-person-plus"></i> <span>Admissions</span></a>
                <a href="{{ route('modules.scheduling') }}" class="{{ request()->routeIs('modules.scheduling') ? 'active' : '' }}" data-title="Scheduling"><i class="bi bi-clock"></i> <span>Scheduling</span></a>
                <a href="{{ route('modules.attendance') }}" class="{{ request()->routeIs('modules.attendance') ? 'active' : '' }}" data-title="Attendance"><i class="bi bi-check2-square"></i> <span>Attendance</span></a>
                <a href="{{ route('modules.billing') }}" class="{{ request()->routeIs('modules.billing') ? 'active' : '' }}" data-title="Billing &amp; Fees"><i class="bi bi-cash-coin"></i> <span>Billing &amp; Fees</span></a>
                <a href="{{ route('modules.reports') }}" class="{{ request()->routeIs('modules.reports') ? 'active' : '' }}" data-title="Reports"><i class="bi bi-bar-chart"></i> <span>Reports</span></a>
            </nav>

            <div class="sidebar-foot">
                <nav class="app-nav">
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}" data-title="Settings"><i class="bi bi-gear"></i> <span>Settings</span></a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-100 text-start" style="background:none;border:none;padding:.55rem .75rem;border-radius:10px;color:var(--text-3);font-weight:500;font-size:.9rem;display:flex;align-items:center;gap:.7rem;">
                            <i class="bi bi-box-arrow-right" style="width:20px;text-align:center;"></i> <span class="logout-label">Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <div class="app-main">
            <header class="app-topbar">
                <button class="icon-btn mobile-nav-toggle" id="sidebarToggle" aria-label="Toggle navigation"><i class="bi bi-list"></i></button>
                <button class="icon-btn d-none d-md-inline-grid" id="collapseToggle" aria-label="Collapse sidebar"><i class="bi bi-layout-sidebar"></i></button>
                <h1 class="h6 m-0 d-none d-md-block" style="color:var(--text-1);font-weight:700;">@yield('title')</h1>
                <div class="topbar-search">
                    <i class="bi bi-search"></i>
                    <input type="search" name="search" placeholder="Search students, subjects, reports..." aria-label="Search">
                </div>
                <div class="topbar-actions">
                    <button class="icon-btn" aria-label="Notifications"><i class="bi bi-bell"></i></button>
                    <div class="dropdown">
                        <button class="icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Theme"><i class="bi bi-brightness-half"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end" style="background:var(--surface-2);border:1px solid var(--border-soft);border-radius:12px;">
                            <li><a class="dropdown-item" href="#" onclick="setTheme('light');return false;" style="color:var(--text-2);"><i class="bi bi-sun"></i> Light</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setTheme('dark');return false;" style="color:var(--text-2);"><i class="bi bi-moon-stars"></i> Dark</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setTheme('device');return false;" style="color:var(--text-2);"><i class="bi bi-display"></i> Device</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="user-chip dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;border:1px solid var(--border-soft);background:var(--surface-2);color:inherit;font-family:inherit;">
                            <span class="avatar">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ auth()->user()->profile_photo }}" alt="Profile photo" style="width:32px;height:32px;border-radius:9px;object-fit:cover;">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </span>
                            <span class="d-none d-sm-block">
                                <span class="name">{{ auth()->user()->name }}</span><br>
                                <span class="role">Administrator</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="background:var(--surface-2);border:1px solid var(--border-soft);border-radius:12px;">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}" style="color:var(--text-2);"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider" style="border-color:var(--border-soft);"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color:#F87171;"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
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
            var collapse = document.getElementById('collapseToggle');
            if (collapse) {
                if (localStorage.getItem('sidebar-collapsed') === '1') sidebar.classList.add('collapsed');
                collapse.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
                });
            }
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
