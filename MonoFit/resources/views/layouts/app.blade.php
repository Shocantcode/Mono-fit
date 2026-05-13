<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MonoFit') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Figtree', sans-serif; margin: 0; padding: 0; }
        .app-shell { max-width: 430px; margin: 0 auto; min-height: 100vh; display: flex; flex-direction: column; position: relative; }

        /* Top Bar */
        .top-bar { position: fixed; top: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; z-index: 50; background: rgba(10,10,10,0.95); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .top-bar-inner { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; }
        .app-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }
        .app-logo-icon { width: 34px; height: 34px; background: linear-gradient(135deg, #ff4500, #ff6a00); border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .app-logo-name { font-size: 19px; font-weight: 800; color: #fff; letter-spacing: -0.4px; }
        .top-bar-right { display: flex; align-items: center; gap: 10px; }
        .profile-btn { width: 36px; height: 36px; background: #1a1a1a; border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; }
        .greeting-text { font-size: 13px; color: #666; }

        /* Main Content */
        .main-content { flex: 1; padding-top: 62px; padding-bottom: 72px; overflow-y: auto; }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 430px; z-index: 50; background: rgba(10,10,10,0.95); backdrop-filter: blur(16px); border-top: 1px solid rgba(255,255,255,0.08); }
        .bottom-nav-inner { display: flex; align-items: center; justify-content: space-around; padding: 8px 4px 10px; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 6px 12px; border-radius: 12px; text-decoration: none; flex: 1; }
        .nav-item.active { color: #ff4500; }
        .nav-item:not(.active) { color: #4a4a4a; }
        .nav-item svg { width: 22px; height: 22px; }
        .nav-label { font-size: 10px; font-weight: 600; letter-spacing: 0.2px; }
        .nav-item.active .nav-dot { width: 4px; height: 4px; border-radius: 50%; background: #ff4500; margin-top: 1px; }
    </style>
</head>
<body>
<div class="app-shell">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-inner">
            <a href="{{ route('dashboard') }}" class="app-logo">
                <div class="app-logo-icon">
                    <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/>
                    </svg>
                </div>
                <span class="app-logo-name">MonoFit</span>
            </a>
            <div class="top-bar-right">
                <a href="{{ route('profile.edit') }}" class="profile-btn" title="Profile">
                    <svg width="18" height="18" fill="none" stroke="#aaa" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="bottom-nav-inner">
            <!-- Home -->
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                @if(request()->routeIs('dashboard'))
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                @endif
                <span class="nav-label">Home</span>
                @if(request()->routeIs('dashboard'))<div class="nav-dot"></div>@endif
            </a>

            <!-- Workout -->
            <a href="{{ route('workout.index') }}" class="nav-item {{ request()->routeIs('workout.*') ? 'active' : '' }}">
                @if(request()->routeIs('workout.*'))
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/></svg>
                @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                @endif
                <span class="nav-label">Workout</span>
                @if(request()->routeIs('workout.*'))<div class="nav-dot"></div>@endif
            </a>

            <!-- Nutrition -->
            <a href="{{ route('nutrition.index') }}" class="nav-item {{ request()->routeIs('nutrition.*') ? 'active' : '' }}">
                @if(request()->routeIs('nutrition.*'))
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.06 22.99h1.66c.84 0 1.53-.64 1.63-1.46L23 5.05h-5V1h-1.97v4.05h-4.97l.3 2.34c1.71.47 3.31 1.32 4.27 2.26 1.44 1.42 2.43 2.89 2.43 5.29v8.05zM1 21.99V21h15.03v.99c0 .55-.45 1-1.01 1H2.01c-.56 0-1.01-.45-1.01-1zm15.03-7c0-8-15.03-8-15.03 0h15.03zM1.02 17h15V19H1.02z"/></svg>
                @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                @endif
                <span class="nav-label">Nutrition</span>
                @if(request()->routeIs('nutrition.*'))<div class="nav-dot"></div>@endif
            </a>

            <!-- Progress -->
            <a href="{{ route('progress.index') }}" class="nav-item {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                @if(request()->routeIs('progress.*'))
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
                @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                @endif
                <span class="nav-label">Progress</span>
                @if(request()->routeIs('progress.*'))<div class="nav-dot"></div>@endif
            </a>

            <!-- Profile -->
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                @if(request()->routeIs('profile.*'))
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                @endif
                <span class="nav-label">Profile</span>
                @if(request()->routeIs('profile.*'))<div class="nav-dot"></div>@endif
            </a>
        </div>
    </nav>

</div>
</body>
</html>
