<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>MonoFit — Train Harder. Live Better.</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #0a0a0a; color: #fff; min-height: 100vh; }
        .max-phone { max-width: 430px; margin: 0 auto; }

        /* Animations */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse-ring { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255,69,0,0.4); } 70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(255,69,0,0); } 100% { transform: scale(0.95); } }
        .fade-up { animation: fadeUp 0.6s ease forwards; }

        /* Header */
        .site-header { position: sticky; top: 0; z-index: 100; background: rgba(10,10,10,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .site-header .inner { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #ff4500, #ff6a00); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .header-actions { display: flex; gap: 8px; }
        .btn-ghost { padding: 8px 16px; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ccc; font-size: 14px; font-weight: 500; text-decoration: none; background: transparent; cursor: pointer; }
        .btn-ghost:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
        .btn-primary { padding: 8px 18px; background: linear-gradient(135deg, #ff4500, #ff6a00); border-radius: 8px; color: #fff; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary:hover { opacity: 0.9; }

        /* Hero */
        .hero { padding: 60px 20px 50px; text-align: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -100px; left: 50%; transform: translateX(-50%); width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,69,0,0.25) 0%, transparent 70%); pointer-events: none; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,69,0,0.12); border: 1px solid rgba(255,69,0,0.3); border-radius: 50px; padding: 6px 14px; margin-bottom: 24px; font-size: 12px; font-weight: 600; color: #ff6a00; letter-spacing: 0.5px; text-transform: uppercase; }
        .hero-title { font-size: 38px; font-weight: 800; line-height: 1.1; letter-spacing: -1px; margin-bottom: 16px; }
        .hero-title span { background: linear-gradient(135deg, #ff4500, #ff9500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-sub { font-size: 16px; color: #888; line-height: 1.6; margin-bottom: 36px; padding: 0 10px; }
        .hero-cta { display: flex; flex-direction: column; gap: 12px; }
        .btn-lg { width: 100%; padding: 16px; border-radius: 14px; font-size: 16px; font-weight: 700; text-decoration: none; text-align: center; display: block; }
        .btn-lg-primary { background: linear-gradient(135deg, #ff4500, #ff6a00); color: #fff; animation: pulse-ring 2s ease infinite; }
        .btn-lg-secondary { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #ccc; }
        .hero-stats { display: flex; justify-content: center; gap: 0; margin-top: 44px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; overflow: hidden; }
        .stat-item { flex: 1; padding: 20px 12px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08); }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-size: 22px; font-weight: 800; color: #ff4500; }
        .stat-label { font-size: 11px; color: #666; margin-top: 3px; }

        /* Section */
        section { padding: 50px 20px; }
        .section-label { font-size: 12px; font-weight: 600; color: #ff4500; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .section-title { font-size: 28px; font-weight: 800; line-height: 1.2; letter-spacing: -0.5px; margin-bottom: 8px; }
        .section-sub { font-size: 14px; color: #777; line-height: 1.6; margin-bottom: 30px; }

        /* Feature cards */
        .features-grid { display: flex; flex-direction: column; gap: 14px; }
        .feature-card { background: #141414; border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 22px; display: flex; align-items: flex-start; gap: 16px; }
        .feature-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-icon svg { width: 24px; height: 24px; }
        .feature-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .feature-desc { font-size: 13px; color: #777; line-height: 1.5; }

        /* Membership plans */
        .plans-section { background: #0d0d0d; }
        .plans-grid { display: flex; flex-direction: column; gap: 14px; }
        .plan-card { background: #141414; border: 1px solid rgba(255,255,255,0.07); border-radius: 20px; padding: 24px; position: relative; overflow: hidden; }
        .plan-card.popular { border-color: #ff4500; background: linear-gradient(145deg, #1a1010, #141414); }
        .popular-badge { position: absolute; top: 16px; right: 16px; background: linear-gradient(135deg, #ff4500, #ff6a00); color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 10px; border-radius: 50px; }
        .plan-name { font-size: 13px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .plan-price { display: flex; align-items: baseline; gap: 4px; margin-bottom: 16px; }
        .plan-amount { font-size: 36px; font-weight: 800; }
        .plan-period { font-size: 14px; color: #666; }
        .plan-features { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        .plan-features li { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #bbb; }
        .check-icon { width: 18px; height: 18px; border-radius: 50%; background: rgba(255,69,0,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .check-icon svg { width: 10px; height: 10px; color: #ff4500; }
        .plan-btn { width: 100%; padding: 13px; border-radius: 12px; font-size: 15px; font-weight: 600; text-align: center; text-decoration: none; display: block; border: none; cursor: pointer; }
        .plan-btn-primary { background: linear-gradient(135deg, #ff4500, #ff6a00); color: #fff; }
        .plan-btn-secondary { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #ccc; }

        /* How it works */
        .steps-grid { display: flex; flex-direction: column; gap: 0; }
        .step-item { display: flex; gap: 20px; padding: 0 0 28px 0; position: relative; }
        .step-item:last-child { padding-bottom: 0; }
        .step-left { display: flex; flex-direction: column; align-items: center; }
        .step-num { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #ff4500, #ff6a00); display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 800; color: #fff; flex-shrink: 0; }
        .step-line { width: 2px; background: linear-gradient(to bottom, #ff4500, transparent); flex: 1; margin-top: 8px; }
        .step-item:last-child .step-line { display: none; }
        .step-content { padding-top: 8px; }
        .step-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .step-desc { font-size: 13px; color: #777; line-height: 1.5; }

        /* Testimonials */
        .testimonials-section { background: #0d0d0d; }
        .testimonials-list { display: flex; flex-direction: column; gap: 14px; }
        .testimonial-card { background: #141414; border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 20px; }
        .testimonial-stars { display: flex; gap: 3px; margin-bottom: 12px; }
        .star { color: #ff9500; font-size: 14px; }
        .testimonial-text { font-size: 14px; color: #bbb; line-height: 1.6; margin-bottom: 16px; font-style: italic; }
        .testimonial-author { display: flex; align-items: center; gap: 12px; }
        .author-avatar { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .author-name { font-size: 14px; font-weight: 600; }
        .author-goal { font-size: 12px; color: #666; }

        /* CTA banner */
        .cta-section { padding: 50px 20px; }
        .cta-card { background: linear-gradient(135deg, #1a0800, #250d00); border: 1px solid rgba(255,69,0,0.3); border-radius: 24px; padding: 36px 24px; text-align: center; position: relative; overflow: hidden; }
        .cta-card::before { content: ''; position: absolute; top: -60px; right: -60px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(255,69,0,0.2) 0%, transparent 70%); pointer-events: none; }
        .cta-title { font-size: 28px; font-weight: 800; line-height: 1.2; margin-bottom: 12px; letter-spacing: -0.5px; }
        .cta-sub { font-size: 14px; color: #888; margin-bottom: 28px; line-height: 1.6; }

        /* Footer */
        footer { background: #080808; border-top: 1px solid rgba(255,255,255,0.06); padding: 36px 20px 24px; }
        .footer-logo { margin-bottom: 16px; }
        .footer-desc { font-size: 13px; color: #555; line-height: 1.6; margin-bottom: 24px; }
        .footer-links { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 28px; }
        .footer-links a { font-size: 13px; color: #555; text-decoration: none; }
        .footer-links a:hover { color: #ccc; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; font-size: 12px; color: #444; text-align: center; }

        /* Divider */
        .divider { height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.06), transparent); margin: 0 20px; }
    </style>
</head>
<body>

<!-- ========== HEADER ========== -->
<div class="max-phone">
    <header class="site-header">
        <div class="inner">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/>
                    </svg>
                </div>
                <span class="logo-text">MonoFit</span>
            </a>
            <div class="header-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Join Free</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- ========== HERO ========== -->
    <section class="hero fade-up">
        <div class="hero-badge">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            #1 Fitness App
        </div>
        <h1 class="hero-title">
            Train Harder.<br>
            <span>Live Better.</span>
        </h1>
        <p class="hero-sub">
            Your all-in-one gym companion — track workouts, monitor nutrition, and crush your fitness goals every single day.
        </p>
        <div class="hero-cta">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-lg btn-lg-primary">Go to Dashboard</a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-lg btn-lg-primary">Start for Free</a>
                @endif
                <a href="{{ route('login') }}" class="btn-lg btn-lg-secondary">Log in to your account</a>
            @endauth
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-num">10K+</div>
                <div class="stat-label">Members</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">500+</div>
                <div class="stat-label">Exercises</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">98%</div>
                <div class="stat-label">Satisfied</div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- ========== FEATURES ========== -->
    <section>
        <p class="section-label">Why MonoFit</p>
        <h2 class="section-title">Everything you need to succeed</h2>
        <p class="section-sub">Built for real people with real fitness goals — from beginners to athletes.</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(255,69,0,0.12);">
                    <svg fill="none" stroke="#ff4500" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Smart Workout Plans</div>
                    <div class="feature-desc">Personalized routines based on your body type, goals, and available equipment. Adjust anytime.</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(59,130,246,0.12);">
                    <svg fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Nutrition Tracking</div>
                    <div class="feature-desc">Log meals, track macros — protein, carbs, fats — and hit your daily calorie targets with ease.</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(16,185,129,0.12);">
                    <svg fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Progress Analytics</div>
                    <div class="feature-desc">Visualize your gains over time. Track weight, streaks, body metrics, and workout history.</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(245,158,11,0.12);">
                    <svg fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Smart Reminders</div>
                    <div class="feature-desc">Never miss a workout or meal. Customizable reminders for training, hydration, and nutrition.</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(139,92,246,0.12);">
                    <svg fill="none" stroke="#8b5cf6" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Body Analysis</div>
                    <div class="feature-desc">Calculate your BMI, BMR, and TDEE. Know your somatotype and get tailored recommendations.</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: rgba(236,72,153,0.12);">
                    <svg fill="none" stroke="#ec4899" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="feature-title">Community Streaks</div>
                    <div class="feature-desc">Build habits with daily streaks. Stay consistent and celebrate milestones on your fitness journey.</div>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- ========== HOW IT WORKS ========== -->
    <section>
        <p class="section-label">How it works</p>
        <h2 class="section-title">Get started in 3 steps</h2>
        <p class="section-sub">Simple setup, powerful results.</p>

        <div class="steps-grid">
            <div class="step-item">
                <div class="step-left">
                    <div class="step-num">1</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-content">
                    <div class="step-title">Create your profile</div>
                    <div class="step-desc">Sign up and tell us about your body, goals, and available equipment. Takes less than 2 minutes.</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-left">
                    <div class="step-num">2</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-content">
                    <div class="step-title">Get your plan</div>
                    <div class="step-desc">We calculate your TDEE, recommend calorie targets, and generate a workout plan tailored to you.</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-left">
                    <div class="step-num">3</div>
                    <div class="step-line"></div>
                </div>
                <div class="step-content">
                    <div class="step-title">Train & track daily</div>
                    <div class="step-desc">Log workouts and meals, track your streak, and watch your body transform week by week.</div>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- ========== FREE FOR EVERYONE ========== -->
    <section style="padding: 50px 20px;">
        <p class="section-label">Access</p>
        <h2 class="section-title">Free for Everyone</h2>
        <p class="section-sub">Every feature, every tool — completely free. No hidden fees, no credit card required.</p>

        <div style="background:linear-gradient(135deg,#0d1a0d,#0a160a);border:1px solid rgba(16,185,129,0.2);border-radius:24px;padding:32px 24px;text-align:center;position:relative;overflow:hidden;margin-bottom:20px;">
            <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;background:radial-gradient(circle,rgba(16,185,129,0.15) 0%,transparent 70%);pointer-events:none;"></div>
            <div style="font-size:48px;margin-bottom:12px;">🎉</div>
            <div style="font-size:13px;font-weight:700;color:#10b981;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">100% Free</div>
            <div style="font-size:34px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:6px;">$0 <span style="font-size:16px;color:#666;font-weight:400;">/ forever</span></div>
            <p style="font-size:14px;color:#777;line-height:1.6;margin-bottom:28px;">We believe everyone deserves access to great fitness tools. MonoFit is completely free — no paywalls, no premium tiers.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="display:block;background:linear-gradient(135deg,#10b981,#059669);color:#fff;text-decoration:none;padding:15px 24px;border-radius:14px;font-size:16px;font-weight:700;">Get Started Free →</a>
            @endif
        </div>

        <div style="display:flex;flex-direction:column;gap:12px;">
            @php
                $allFeatures = [
                    ['icon'=>'⚡','text'=>'Full workout tracking & exercise library','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)'],
                    ['icon'=>'🥗','text'=>'Calorie, macro & water logging','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)'],
                    ['icon'=>'📊','text'=>'Progress analytics & body metrics','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)'],
                    ['icon'=>'🔥','text'=>'Daily streak counter & achievements','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)'],
                    ['icon'=>'🧮','text'=>'BMI, BMR & TDEE calculator','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)'],
                    ['icon'=>'📅','text'=>'Workout schedule & planner','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)'],
                ];
            @endphp
            @foreach($allFeatures as $feat)
            <div style="background:{{ $feat['color'] }};border:1px solid {{ $feat['border'] }};border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px;">
                <span style="font-size:22px;flex-shrink:0;">{{ $feat['icon'] }}</span>
                <span style="font-size:14px;color:#ccc;font-weight:500;">{{ $feat['text'] }}</span>
                <div style="margin-left:auto;width:20px;height:20px;background:rgba(16,185,129,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="10" height="10" fill="none" stroke="#10b981" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <div class="divider"></div>

    <!-- ========== TESTIMONIALS ========== -->
    <section class="testimonials-section">
        <p class="section-label">Testimonials</p>
        <h2 class="section-title">Real people, real results</h2>
        <p class="section-sub">Thousands of members have transformed their lives with MonoFit.</p>

        <div class="testimonials-list">
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <p class="testimonial-text">"I lost 12kg in 4 months using MonoFit. The nutrition tracking is incredibly accurate and the workout plans are challenging but achievable. Best fitness app I've ever used."</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #ff4500, #ff6a00);">R</div>
                    <div>
                        <div class="author-name">Reza Kartika</div>
                        <div class="author-goal">Lost 12kg · 4 months</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <p class="testimonial-text">"The body analysis feature blew my mind. I never knew I was an ectomorph until MonoFit told me — and the customized plan made a massive difference in my muscle gains."</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #3b82f6, #6366f1);">A</div>
                    <div>
                        <div class="author-name">Andi Pratama</div>
                        <div class="author-goal">Gained 8kg muscle · 6 months</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <p class="testimonial-text">"I've tried 10+ fitness apps and MonoFit is the only one I actually stuck with. The streak system keeps me motivated every single day. 90-day streak and counting!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">S</div>
                    <div>
                        <div class="author-name">Sari Dewi</div>
                        <div class="author-goal">90-day streak · Still going!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- ========== CTA BANNER ========== -->
    <div class="cta-section">
        <div class="cta-card">
            <h2 class="cta-title">Ready to transform<br>your body?</h2>
            <p class="cta-sub">Join 10,000+ members who are already crushing their fitness goals with MonoFit.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-lg btn-lg-primary" style="display:block; text-decoration:none; padding:16px; border-radius:14px; font-size:16px; font-weight:700; text-align:center; background:linear-gradient(135deg,#ff4500,#ff6a00); color:#fff;">Open Dashboard</a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-lg btn-lg-primary" style="display:block; text-decoration:none; padding:16px; border-radius:14px; font-size:16px; font-weight:700; text-align:center; background:linear-gradient(135deg,#ff4500,#ff6a00); color:#fff;">Start for Free Today</a>
                @endif
            @endauth
        </div>
    </div>

    <!-- ========== FOOTER ========== -->
    <footer>
        <div class="footer-logo">
            <a href="/" class="logo">
                <div class="logo-icon" style="width:32px;height:32px;background:linear-gradient(135deg,#ff4500,#ff6a00);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                        <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29l-1.43-1.43z"/>
                    </svg>
                </div>
                <span style="font-size:18px;font-weight:800;color:#fff;margin-left:8px;">MonoFit</span>
            </a>
        </div>
        <p class="footer-desc">Your ultimate gym companion. Track. Train. Transform.</p>
        <div class="footer-links">
            <a href="#">Features</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} MonoFit. All rights reserved. Built with ❤️ for fitness lovers.
        </div>
    </footer>

</div><!-- end .max-phone -->
</body>
</html>
