@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Progress</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">Track your transformation</p>
    </div>

    {{-- Streak Banner --}}
    <div style="background:linear-gradient(135deg,#1a1000,#201500);border:1px solid rgba(245,158,11,0.3);border-radius:20px;padding:20px;display:flex;align-items:center;gap:16px;">
        <div style="font-size:44px;line-height:1;">🔥</div>
        <div>
            <div style="font-size:32px;font-weight:800;color:#f59e0b;line-height:1;">{{ $streak ?? 0 }} <span style="font-size:14px;color:#888;font-weight:400;">days</span></div>
            <div style="font-size:14px;color:#ccc;margin-top:4px;font-weight:600;">Current Streak</div>
            <div style="font-size:12px;color:#666;margin-top:2px;">Keep going — your best is ahead!</div>
        </div>
    </div>

    {{-- Key Metrics --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Body Metrics</h3>
        @php
            $onboarding = Auth::user()->onboarding ?? null;
        @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div style="background:rgba(255,69,0,0.08);border:1px solid rgba(255,69,0,0.15);border-radius:14px;padding:16px;">
                <div style="font-size:11px;color:#666;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Weight</div>
                <div style="font-size:26px;font-weight:800;color:#fff;">{{ $onboarding?->weight ?? '--' }}</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">kg</div>
            </div>
            <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);border-radius:14px;padding:16px;">
                <div style="font-size:11px;color:#666;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">BMI</div>
                <div style="font-size:26px;font-weight:800;color:#3b82f6;">{{ $onboarding?->bmi ? number_format($onboarding->bmi, 1) : '--' }}</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">
                    @if($onboarding?->bmi)
                        @if($onboarding->bmi < 18.5) Underweight
                        @elseif($onboarding->bmi < 25) Normal
                        @elseif($onboarding->bmi < 30) Overweight
                        @else Obese
                        @endif
                    @else
                        Not set
                    @endif
                </div>
            </div>
            <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);border-radius:14px;padding:16px;">
                <div style="font-size:11px;color:#666;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">TDEE</div>
                <div style="font-size:22px;font-weight:800;color:#10b981;">{{ $onboarding?->tdee ? number_format($onboarding->tdee) : '--' }}</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">kcal/day</div>
            </div>
            <div style="background:rgba(139,92,246,0.08);border:1px solid rgba(139,92,246,0.15);border-radius:14px;padding:16px;">
                <div style="font-size:11px;color:#666;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Body Type</div>
                <div style="font-size:18px;font-weight:800;color:#8b5cf6;text-transform:capitalize;">{{ $onboarding?->somatotype ?? '--' }}</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Somatotype</div>
            </div>
        </div>
        @if(!$onboarding)
        <div style="margin-top:14px;text-align:center;">
            <a href="{{ route('onboarding.show') }}" style="display:inline-block;background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;text-decoration:none;padding:10px 24px;border-radius:10px;font-size:13px;font-weight:600;">Complete Onboarding to see metrics</a>
        </div>
        @endif
    </div>

    {{-- Weekly Activity Chart --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;">Weekly Activity</h3>
            <span style="font-size:12px;color:#ff4500;font-weight:600;">This Week</span>
        </div>
        @php
            $weekDays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
            $heights = [65, 90, 45, 100, 30, 80, 55];
            $todayIndex = (int) now()->format('N') - 1;
        @endphp
        <div style="display:flex;align-items:flex-end;gap:8px;height:90px;">
            @foreach($weekDays as $i => $day)
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                <div style="width:100%;background:{{ $i === $todayIndex ? 'linear-gradient(180deg,#ff4500,#ff6a00)' : 'rgba(255,255,255,0.07)' }};border-radius:6px 6px 4px 4px;height:{{ $heights[$i] }}%;position:relative;transition:all 0.3s;min-height:8px;">
                    @if($i === $todayIndex)
                    <div style="position:absolute;top:-6px;left:50%;transform:translateX(-50%);width:6px;height:6px;background:#ff4500;border-radius:50%;"></div>
                    @endif
                </div>
                <span style="font-size:10px;color:{{ $i === $todayIndex ? '#ff4500' : '#444' }};font-weight:{{ $i === $todayIndex ? '700' : '400' }};">{{ $day }}</span>
            </div>
            @endforeach
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.06);">
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#fff;">5</div>
                <div style="font-size:11px;color:#555;">Workouts</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#fff;">2,450</div>
                <div style="font-size:11px;color:#555;">Avg Kcal</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:18px;font-weight:700;color:#fff;">2.4L</div>
                <div style="font-size:11px;color:#555;">Avg Water</div>
            </div>
        </div>
    </div>

    {{-- Goal Progress --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:16px;">Goal Progress</h3>
        @php
            $goals = [
                ['label'=>'Weight Loss Goal','current'=>78,'target'=>70,'unit'=>'kg','color'=>'#ff4500','icon'=>'⚖️'],
                ['label'=>'Weekly Workouts','current'=>5,'target'=>6,'unit'=>'sessions','color'=>'#10b981','icon'=>'🏋️'],
                ['label'=>'Daily Water','current'=>2.2,'target'=>3,'unit'=>'liters','color'=>'#06b6d4','icon'=>'💧'],
                ['label'=>'Protein Goal','current'=>120,'target'=>150,'unit'=>'g/day','color'=>'#3b82f6','icon'=>'🥩'],
            ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($goals as $goal)
            @php $pct = min(100, round($goal['current'] / $goal['target'] * 100)); @endphp
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:16px;">{{ $goal['icon'] }}</span>
                        <span style="font-size:13px;font-weight:600;color:#ccc;">{{ $goal['label'] }}</span>
                    </div>
                    <span style="font-size:12px;color:{{ $goal['color'] }};font-weight:600;">{{ $goal['current'] }} / {{ $goal['target'] }} {{ $goal['unit'] }}</span>
                </div>
                <div style="height:7px;background:rgba(255,255,255,0.06);border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $goal['color'] }};border-radius:4px;transition:width 0.5s;"></div>
                </div>
                <div style="font-size:11px;color:#444;margin-top:3px;">{{ $pct }}% complete</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Achievements --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Achievements 🏆</h3>
        @php
            $badges = [
                ['emoji'=>'🔥','name'=>'On Fire','desc'=>'7 day streak','unlocked'=>true],
                ['emoji'=>'💪','name'=>'Iron Will','desc'=>'30 workouts logged','unlocked'=>true],
                ['emoji'=>'🥗','name'=>'Clean Eater','desc'=>'14 days on target macros','unlocked'=>true],
                ['emoji'=>'💧','name'=>'Hydrated','desc'=>'Hit water goal 7 days','unlocked'=>false],
                ['emoji'=>'🏃','name'=>'Cardio King','desc'=>'10 cardio sessions','unlocked'=>false],
                ['emoji'=>'⚡','name'=>'Power Week','desc'=>'6 workouts in one week','unlocked'=>false],
            ];
        @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
            @foreach($badges as $badge)
            <div style="background:{{ $badge['unlocked'] ? 'rgba(245,158,11,0.08)' : 'rgba(255,255,255,0.03)' }};border:1px solid {{ $badge['unlocked'] ? 'rgba(245,158,11,0.25)' : 'rgba(255,255,255,0.06)' }};border-radius:14px;padding:14px;text-align:center;position:relative;">
                <div style="font-size:26px;margin-bottom:6px;{{ !$badge['unlocked'] ? 'filter:grayscale(1);opacity:0.3;' : '' }}">{{ $badge['emoji'] }}</div>
                <div style="font-size:11px;font-weight:700;color:{{ $badge['unlocked'] ? '#fff' : '#444' }};">{{ $badge['name'] }}</div>
                <div style="font-size:10px;color:{{ $badge['unlocked'] ? '#666' : '#333' }};margin-top:2px;line-height:1.3;">{{ $badge['desc'] }}</div>
                @if(!$badge['unlocked'])
                <div style="position:absolute;top:8px;right:8px;">
                    <svg width="12" height="12" fill="#333" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Body Calculator CTA --}}
    <div style="background:linear-gradient(135deg,#0d0d1a,#0a0a1a);border:1px solid rgba(139,92,246,0.2);border-radius:20px;padding:18px;display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;background:rgba(139,92,246,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:22px;">🧮</div>
        <div style="flex:1;">
            <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:3px;">Body Calculator</div>
            <div style="font-size:12px;color:#666;">Calculate your BMI, BMR & TDEE</div>
        </div>
        <a href="{{ route('calculator.index') }}" style="background:rgba(139,92,246,0.2);border:1px solid rgba(139,92,246,0.3);color:#8b5cf6;text-decoration:none;padding:8px 14px;border-radius:10px;font-size:12px;font-weight:700;flex-shrink:0;">Open →</a>
    </div>

    {{-- Log Weight --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;margin-bottom:4px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Log Today's Weight</h3>
        <form action="#" method="POST" style="display:flex;gap:10px;align-items:flex-end;">
            @csrf
            <div style="flex:1;">
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Weight (kg)</label>
                <input type="number" name="weight" placeholder="{{ $onboarding?->weight ?? '70' }}" step="0.1" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:16px;outline:none;">
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:12px 20px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;white-space:nowrap;">Save</button>
        </form>
    </div>

</div>
@endsection
