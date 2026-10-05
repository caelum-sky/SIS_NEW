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
                <a href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i> <span>Dashboard</span></a>
                <a href="{{ route('students.index') }}"><i class="bi bi-people"></i> <span>Students</span></a>
                <a href="{{ route('subjects.index') }}"><i class="bi bi-book"></i> <span>Subjects</span></a>
                <a href="{{ route('profile.edit') }}" class="active" data-title="Settings"><i class="bi bi-gear"></i> <span>Settings</span></a>
            </nav>
            <div class="sidebar-foot">
                <nav class="app-nav">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:.55rem .75rem;border-radius:10px;color:var(--text-3);font-weight:500;font-size:.9rem;display:flex;align-items:center;gap:.7rem;width:100%;text-align:left;">
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
                <div class="topbar-actions">
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
            <main class="app-content">{{ $slot }}</main>
        </div>
    </div>
    <script>
        (function () {
            var t = document.getElementById('sidebarToggle'), s = document.getElementById('appSidebar'), b = document.getElementById('sidebarBackdrop');
            function c(){s.classList.remove('open');b.classList.remove('open');}
            if(t)t.addEventListener('click',function(){s.classList.toggle('open');b.classList.toggle('open');});
            if(b)b.addEventListener('click',c);
            var cl = document.getElementById('collapseToggle');
            if(cl){
                if(localStorage.getItem('sidebar-collapsed')==='1')s.classList.add('collapsed');
                cl.addEventListener('click',function(){s.classList.toggle('collapsed');localStorage.setItem('sidebar-collapsed',s.classList.contains('collapsed')?'1':'0');});
            }
        })();
    </script>
</body>

</html>
