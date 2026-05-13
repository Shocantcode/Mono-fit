<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — MonoFit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #0a0a0a; color: #fff; min-height: 100vh; }
        .max-phone { max-width: 430px; margin: 0 auto; min-height: 100vh; display: flex; flex-direction: column; position: relative; overflow: hidden; }
        .bg-glow { position: absolute; top: -120px; left: 50%; transform: translateX(-50%); width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,69,0,0.18) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        .auth-header { position: relative; z-index: 1; padding: 20px 20px 0; display: flex; align-items: center; justify-content: space-between; }
        .back-btn { width: 38px; height: 38px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 11px; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .auth-body { position: relative; z-index: 1; flex: 1; padding: 32px 24px 48px; display: flex; flex-direction: column; }
        .auth-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; }
        .logo-icon { width: 44px; height: 44px; background: linear-gradient(135deg, #ff4500, #ff6a00); border-radius: 13px; display: flex; align-items: center; justify-content: center; }
        .auth-title { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -0.7px; line-height: 1.15; margin-bottom: 8px; }
        .auth-sub { font-size: 14px; color: #666; margin-bottom: 36px; line-height: 1.5; }
        .form-group { margin-bottom: 16px; }
        .form-label { font-size: 11px; font-weight: 700; color: #777; display: block; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase; }
        .form-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.09); border-radius: 13px; padding: 15px 16px; color: #fff; font-size: 15px; font-family: 'Figtree', sans-serif; outline: none; transition: border-color 0.2s, background 0.2s; }
        .form-input:focus { border-color: rgba(255,69,0,0.55); background: rgba(255,255,255,0.07); }
        .form-input::placeholder { color: #3a3a3a; }
        .form-input.has-error { border-color: rgba(239,68,68,0.5); }
        .form-error { font-size: 12px; color: #ef4444; margin-top: 6px; display: flex; align-items: center; gap: 4px; }
        .form-row { display: flex; align-items: center; justify-content: space-between; margin: 18px 0 28px; }
        .remember-label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #777; cursor: pointer; }
        .remember-cb { width: 16px; height: 16px; accent-color: #ff4500; cursor: pointer; border-radius: 4px; }
        .forgot-link { font-size: 13px; color: #ff4500; text-decoration: none; font-weight: 600; }
        .btn-submit { width: 100%; padding: 16px; background: linear-gradient(135deg, #ff4500, #ff6a00); border: none; border-radius: 14px; color: #fff; font-size: 16px; font-weight: 700; font-family: 'Figtree', sans-serif; cursor: pointer; margin-bottom: 28px; letter-spacing: -0.2px; }
        .btn-submit:hover { opacity: 0.92; }
        .auth-footer { text-align: center; font-size: 14px; color: #555; }
        .auth-footer a { color: #ff4500; font-weight: 600; text-decoration: none; }
        .session-status { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); border-radius: 12px; padding: 12px 16px; font-size: 13px; color: #10b981; margin-bottom: 20px; }
        .divider { display: flex; align-items: center; gap: 12px; margin: 8px 0 24px; }
        .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.07); }
        .divider-text { font-size: 12px; color: #333; }
    </style>
</head>
<body>
<div class="max-phone">
    <div class="bg-glow"></div>

    <div class="auth-header">
        <a href="/" class="back-btn">
            <svg width="18" height="18" fill="none" stroke="#888" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <a href="{{ route('register') }}" style="font-size:13px;color:#ff4500;font-weight:600;text-decoration:none;">Join Free →</a>
    </div>

    <div class="auth-body">
        <div class="auth-logo">
            <div class="logo-icon">
                <svg width="22" height="22" fill="white" viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/></svg>
            </div>
            <span style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;">MonoFit</span>
        </div>

        <h1 class="auth-title">Welcome<br>back 👋</h1>
        <p class="auth-sub">Sign in to continue your fitness journey.</p>

        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-input {{ $errors->has('email') ? 'has-error' : '' }}"
                       type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="your@email.com"
                       required autofocus autocomplete="username">
                @if ($errors->has('email'))
                    <div class="form-error">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-input {{ $errors->has('password') ? 'has-error' : '' }}"
                       type="password" id="password" name="password"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                @if ($errors->has('password'))
                    <div class="form-error">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" class="remember-cb" name="remember">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">Log In</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">New to MonoFit?</span>
            <div class="divider-line"></div>
        </div>

        <div class="auth-footer">
            <a href="{{ route('register') }}" style="display:block;width:100%;padding:15px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:14px;color:#ccc;font-size:15px;font-weight:600;text-decoration:none;text-align:center;">Create a free account</a>
        </div>
    </div>
</div>
</body>
</html>
