@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Greeting Card --}}
    <div style="background: linear-gradient(135deg, #1a0800, #250d00); border: 1px solid rgba(255,69,0,0.25); border-radius: 20px; padding: 22px; position: relative; overflow: hidden;">
        <div style="position:absolute;top:-40px;right:-40px;width:130px;height:130px;background:radial-gradient(circle,rgba(255,69,0,0.2) 0%,transparent 70%);pointer-events:none;"></div>
        <p style="font-size:13px;color:#888;margin-bottom:4px;">Welcome back 👋</p>
        <h2 style="font-size:24px;font-weight:800;color:#fff;margin-bottom:6px;letter-spacing:-0.5px;">{{ Auth::user()->name }}</h2>
        <p style="font-size:13px;color:#666;">{{ now()->format('l, d F Y') }}</p>
        <div style="margin-top:16px;display:grid;grid-template-columns:repeat(3, minmax(0, 1fr));gap:8px;">
            <div style="background:rgba(255,69,0,0.15);border:1px solid rgba(255,69,0,0.3);border-radius:10px;padding:14px;text-align:center;">
                <div style="font-size:18px;font-weight:800;color:#ff4500;">{{ $streak ?? 0 }}</div>
                <div style="font-size:10px;color:#888;margin-top:1px;">Day Streak 🔥</div>
            </div>
            <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:14px;text-align:center;">
                <div style="font-size:13px;font-weight:600;color:#ccc;">Keep it up! Your consistency</div>
                <div style="font-size:12px;color:#666;margin-top:2px;">is building a better you 💪</div>
            </div>
            <div style="background:rgba(148,163,184,0.09);border:1px solid rgba(148,163,184,0.18);border-radius:10px;padding:14px;text-align:center;">
                <div style="font-size:13px;font-weight:600;color:#cbd5e1;">BMI</div>
                <div style="font-size:24px;font-weight:800;color:#fff;margin-top:4px;">{{ $bmi ?? '—' }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">{{ $bmiLabel ?? 'Complete profile' }}</div>
            </div>
        </div>
    </div>

    {{-- Today's Nutrition --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;">Today's Calories</h3>
            <a href="{{ route('nutrition.index') }}" style="font-size:12px;color:#ff4500;text-decoration:none;font-weight:600;">Log Meal →</a>
        </div>

        {{-- Calorie Ring --}}
        <div style="text-align:center;margin-bottom:18px;">
            <div style="display:inline-flex;flex-direction:column;align-items:center;background:rgba(255,69,0,0.08);border:2px solid rgba(255,69,0,0.2);border-radius:50%;width:110px;height:110px;justify-content:center;">
                <span style="font-size:28px;font-weight:800;color:#ff4500;">{{ $calories ?? 0 }}</span>
                <span style="font-size:11px;color:#888;">kcal</span>
            </div>
            <p style="font-size:12px;color:#555;margin-top:8px;">of ~2000 kcal goal</p>
        </div>

        {{-- Macros --}}
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
            <div style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);border-radius:12px;padding:12px;text-align:center;">
                <div style="font-size:18px;font-weight:800;color:#3b82f6;">{{ $protein ?? 0 }}g</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Protein</div>
            </div>
            <div style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:12px;padding:12px;text-align:center;">
                <div style="font-size:18px;font-weight:800;color:#f59e0b;">{{ $carbs ?? 0 }}g</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Carbs</div>
            </div>
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:12px;padding:12px;text-align:center;">
                <div style="font-size:18px;font-weight:800;color:#ef4444;">{{ $fat ?? 0 }}g</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Fat</div>
            </div>
        </div>
    </div>

    {{-- Water & Quick Stats Row --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:18px;">
            <div style="font-size:24px;margin-bottom:6px;">💧</div>
            <div style="font-size:22px;font-weight:800;color:#60a5fa;">{{ $water ?? 0 }}<span style="font-size:13px;color:#666;"> L</span></div>
            <div style="font-size:12px;color:#666;margin-top:2px;">Water intake</div>
            <a href="{{ route('nutrition.index') }}" style="display:block;margin-top:10px;font-size:11px;color:#ff4500;text-decoration:none;font-weight:600;">+ Add water</a>
        </div>
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:18px;">
            <div style="font-size:24px;margin-bottom:6px;">🏋️</div>
            @if(isset($workout))
                <div style="font-size:22px;font-weight:800;color:#10b981;">{{ count($workout['exercises'] ?? []) }}</div>
                <div style="font-size:12px;color:#666;margin-top:2px;">Exercises done</div>
            @else
                <div style="font-size:18px;font-weight:700;color:#555;">Rest</div>
                <div style="font-size:12px;color:#666;margin-top:2px;">No workout yet</div>
            @endif
            <a href="{{ route('workout.index') }}" style="display:block;margin-top:10px;font-size:11px;color:#ff4500;text-decoration:none;font-weight:600;">
                {{ isset($workout) ? 'View workout' : 'Start workout' }}
            </a>
        </div>
    </div>

    {{-- Today's Workout --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;">Today's Workout</h3>
            <a href="{{ route('workout.index') }}" style="font-size:12px;color:#ff4500;text-decoration:none;font-weight:600;">See all →</a>
        </div>
        @if(isset($workout) && isset($workout['exercises']) && count($workout['exercises']) > 0)
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($workout['exercises'] as $exercise)
                <div style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.04);border-radius:12px;padding:12px;">
                    <div style="width:36px;height:36px;background:rgba(255,69,0,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="18" height="18" fill="none" stroke="#ff4500" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:14px;font-weight:600;color:#fff;">{{ $exercise['name'] }}</div>
                        <div style="font-size:12px;color:#666;margin-top:2px;">{{ $exercise['sets'] }} sets × {{ $exercise['reps'] }} reps</div>
                    </div>
                    <div style="width:22px;height:22px;border-radius:50%;background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);display:flex;align-items:center;justify-content:center;">
                        <svg width="12" height="12" fill="none" stroke="#10b981" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center;padding:24px 0;">
                <div style="font-size:36px;margin-bottom:8px;">🏋️</div>
                <p style="font-size:14px;color:#555;margin-bottom:16px;">No workout logged today yet.</p>
                <a href="{{ route('workout.index') }}" style="display:inline-block;background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;text-decoration:none;padding:10px 24px;border-radius:10px;font-size:13px;font-weight:600;">Start Workout</a>
            </div>
        @endif
    </div>

    {{-- Quick Actions --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Quick Actions</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <a href="{{ route('workout.index') }}" style="background:rgba(255,69,0,0.1);border:1px solid rgba(255,69,0,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">⚡</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">Log Workout</div>
            </a>
            <a href="{{ route('nutrition.index') }}" style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">🥗</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">Log Meal</div>
            </a>
            <a href="{{ route('progress.index') }}" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">📊</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">View Progress</div>
            </a>
            <a href="{{ route('profile.edit') }}" style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">👤</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">My Profile</div>
            </a>
            <a href="{{ route('schedule.index') }}" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">📅</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">Schedule</div>
            </a>
            <a href="{{ route('exercises.index') }}" style="background:rgba(6,182,212,0.1);border:1px solid rgba(6,182,212,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">📚</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">Exercises</div>
            </a>
            <a href="{{ route('calculator.index') }}" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:14px;padding:16px;text-align:center;text-decoration:none;display:block;">
                <div style="font-size:26px;margin-bottom:6px;">🧮</div>
                <div style="font-size:13px;font-weight:600;color:#fff;">Calculator</div>
            </a>
        </div>
    </div>

    {{-- Weekly Summary placeholder --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:4px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:4px;">Weekly Summary</h3>
        <p style="font-size:12px;color:#555;margin-bottom:16px;">Past 7 days activity</p>
        <div style="display:flex;align-items:flex-end;justify-content:space-between;height:70px;gap:8px;">
            @php
                $days = ['M','T','W','T','F','S','S'];
                $heights = [40, 70, 55, 80, 35, 90, 60];
                $today = (int) now()->format('N') - 1;
            @endphp
            @foreach($days as $i => $day)
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                <div style="width:100%;background:{{ $i === $today ? 'linear-gradient(180deg,#ff4500,#ff6a00)' : 'rgba(255,255,255,0.06)' }};border-radius:6px;height:{{ $heights[$i] }}%;transition:all 0.3s;"></div>
                <span style="font-size:10px;color:{{ $i === $today ? '#ff4500' : '#444' }};font-weight:{{ $i === $today ? '700' : '400' }};">{{ $day }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
