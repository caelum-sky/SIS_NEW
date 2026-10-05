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
            <a href="{{ route('student.dashboard') }}" class="brand">
                <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                <span>
                    <span class="brand-name">{{ config('app.school_name') }}</span><br>
                    <span class="brand-sub">Student Portal</span>
                </span>
            </a>

            <div class="nav-section">Portal</div>
            <nav class="app-nav">
                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}" data-title="My Grades"><i class="bi bi-grid-1x2"></i> <span>My Grades</span></a>
                <a href="{{ route('student.requirements.index') }}" class="{{ request()->routeIs('student.requirements.*') ? 'active' : '' }}" data-title="Requirements"><i class="bi bi-file-earmark-arrow-up"></i> <span>Requirements</span></a>
                <a href="{{ route('student.cor.download') }}"><i class="bi bi-file-pdf"></i> <span>Download COR</span></a>
                <a href="{{ route('student.profile.edit') }}" class="{{ request()->routeIs('student.profile.*') ? 'active' : '' }}" data-title="My Profile"><i class="bi bi-person-circle"></i> <span>My Profile</span></a>
            </nav>

            <div class="sidebar-foot">
                <nav class="app-nav">
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
                <div class="topbar-actions">
                    <button class="icon-btn" aria-label="Notifications"><i class="bi bi-bell"></i></button>
                    <div class="dropdown">
                        <button type="button" class="user-chip dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;border:1px solid var(--border-soft);background:var(--surface-2);color:inherit;font-family:inherit;">
                            <span class="avatar">{{ strtoupper(substr(auth('student')->user()->name, 0, 1)) }}</span>
                            <span class="d-none d-sm-block">
                                <span class="name">{{ auth('student')->user()->name }}</span><br>
                                <span class="role">Student</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="background:var(--surface-2);border:1px solid var(--border-soft);border-radius:12px;">
                            <li><a class="dropdown-item" href="{{ route('student.profile.edit') }}" style="color:var(--text-2);"><i class="bi bi-gear"></i> Settings</a></li>
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
