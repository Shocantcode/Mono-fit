@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Schedule</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">Your weekly workout plan</p>
    </div>

    @php
        $todayIndex = (int) now()->format('N') - 1; // 0=Mon, 6=Sun
        $days = [
            ['short'=>'Mon','full'=>'Monday'],
            ['short'=>'Tue','full'=>'Tuesday'],
            ['short'=>'Wed','full'=>'Wednesday'],
            ['short'=>'Thu','full'=>'Thursday'],
            ['short'=>'Fri','full'=>'Friday'],
            ['short'=>'Sat','full'=>'Saturday'],
            ['short'=>'Sun','full'=>'Sunday'],
        ];
        $schedule = [
            0 => ['name'=>'Push Day','type'=>'Workout','muscles'=>'Chest · Shoulders · Triceps','emoji'=>'💪','color'=>'rgba(255,69,0,0.12)','border'=>'rgba(255,69,0,0.25)','accent'=>'#ff4500','exercises'=>['Bench Press 4×8','Overhead Press 3×10','Incline DB Press 3×12','Lateral Raises 3×15','Tricep Dips 3×12']],
            1 => ['name'=>'Pull Day','type'=>'Workout','muscles'=>'Back · Biceps','emoji'=>'🏋️','color'=>'rgba(59,130,246,0.12)','border'=>'rgba(59,130,246,0.25)','accent'=>'#3b82f6','exercises'=>['Deadlift 4×5','Pull-Ups 4×8','Barbell Row 3×10','Lat Pulldown 3×12','Barbell Curl 3×12']],
            2 => ['name'=>'Leg Day','type'=>'Workout','muscles'=>'Quads · Hamstrings · Glutes','emoji'=>'🦵','color'=>'rgba(16,185,129,0.12)','border'=>'rgba(16,185,129,0.25)','accent'=>'#10b981','exercises'=>['Back Squat 4×8','Romanian Deadlift 3×10','Leg Press 3×12','Walking Lunges 3×20','Hip Thrust 3×15']],
            3 => ['name'=>'Rest Day','type'=>'Rest','muscles'=>'Recovery & Stretching','emoji'=>'😴','color'=>'rgba(255,255,255,0.04)','border'=>'rgba(255,255,255,0.08)','accent'=>'#555','exercises'=>['Light stretching','Foam rolling','Active recovery walk']],
            4 => ['name'=>'Push Day','type'=>'Workout','muscles'=>'Chest · Shoulders · Triceps','emoji'=>'💪','color'=>'rgba(255,69,0,0.12)','border'=>'rgba(255,69,0,0.25)','accent'=>'#ff4500','exercises'=>['Incline Bench Press 4×8','Arnold Press 3×10','Cable Flyes 3×12','Lateral Raises 4×15','Skull Crushers 3×12']],
            5 => ['name'=>'Full Body','type'=>'Workout','muscles'=>'All Muscle Groups','emoji'=>'⚡','color'=>'rgba(245,158,11,0.12)','border'=>'rgba(245,158,11,0.25)','accent'=>'#f59e0b','exercises'=>['Squat 3×10','Bench Press 3×10','Barbell Row 3×10','Overhead Press 3×10','Burpees 3×20']],
            6 => ['name'=>'Rest Day','type'=>'Rest','muscles'=>'Full Rest & Meal Prep','emoji'=>'🧘','color'=>'rgba(255,255,255,0.04)','border'=>'rgba(255,255,255,0.08)','accent'=>'#555','exercises'=>['No training today','Focus on nutrition','Sleep & recovery']],
        ];
    @endphp

    {{-- Week Row --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:16px;">
        <div style="font-size:12px;color:#555;margin-bottom:12px;font-weight:600;">{{ now()->startOfWeek()->format('d M') }} — {{ now()->endOfWeek()->format('d M Y') }}</div>
        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;">
            @foreach($days as $i => $day)
            @php $s = $schedule[$i]; $isToday = $i === $todayIndex; @endphp
            <div onclick="showDay({{ $i }})" id="day-btn-{{ $i }}"
                 style="display:flex;flex-direction:column;align-items:center;gap:4px;padding:8px 4px;border-radius:12px;cursor:pointer;background:{{ $isToday ? 'rgba(255,69,0,0.12)' : 'transparent' }};border:1px solid {{ $isToday ? 'rgba(255,69,0,0.3)' : 'transparent' }};">
                <span style="font-size:10px;font-weight:600;color:{{ $isToday ? '#ff4500' : '#444' }};">{{ $day['short'] }}</span>
                <div style="font-size:20px;">{{ $s['emoji'] }}</div>
                @if($s['type'] === 'Workout')
                    <div style="width:5px;height:5px;border-radius:50%;background:{{ $isToday ? '#ff4500' : 'rgba(255,69,0,0.3)' }};"></div>
                @else
                    <div style="width:5px;height:5px;"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Day Detail Cards --}}
    @foreach($schedule as $i => $s)
    @php $isToday = $i === $todayIndex; @endphp
    <div id="day-card-{{ $i }}" style="display:{{ $isToday ? 'block' : 'none' }};">
        {{-- Day Title --}}
        <div style="background:{{ $s['color'] }};border:1px solid {{ $s['border'] }};border-radius:20px;padding:22px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-40px;right:-40px;width:130px;height:130px;background:radial-gradient(circle,{{ $s['color'] }} 0%,transparent 70%);pointer-events:none;"></div>
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
                <div style="font-size:36px;">{{ $s['emoji'] }}</div>
                <div>
                    <div style="font-size:11px;font-weight:700;color:{{ $s['accent'] }};text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">{{ $days[$i]['full'] }}{{ $isToday ? ' · Today' : '' }}</div>
                    <div style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;">{{ $s['name'] }}</div>
                    <div style="font-size:13px;color:#777;margin-top:2px;">{{ $s['muscles'] }}</div>
                </div>
            </div>
            @if($s['type'] === 'Workout' && $isToday)
            <a href="{{ route('workout.index') }}" style="display:block;width:100%;background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;text-decoration:none;padding:13px;border-radius:12px;font-size:14px;font-weight:700;text-align:center;">Start Today's Workout ⚡</a>
            @elseif($s['type'] === 'Rest')
            <div style="background:rgba(255,255,255,0.04);border-radius:12px;padding:12px;text-align:center;font-size:13px;color:#555;">Take it easy today. Your muscles are recovering 💪</div>
            @endif
        </div>

        {{-- Exercise List --}}
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <h3 style="font-size:15px;font-weight:700;color:#fff;margin-bottom:14px;">{{ $s['type'] === 'Workout' ? "Today's Exercises" : "Recovery Plan" }}</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($s['exercises'] as $j => $exName)
                <div style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:12px 14px;">
                    <div style="width:28px;height:28px;background:{{ $s['color'] }};border:1px solid {{ $s['border'] }};border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:800;color:{{ $s['accent'] }};">{{ $j + 1 }}</div>
                    <span style="font-size:14px;color:#ccc;font-weight:500;">{{ $exName }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    {{-- Weekly Stats --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:15px;font-weight:700;color:#fff;margin-bottom:16px;">This Week's Plan</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
            <div style="text-align:center;background:rgba(255,69,0,0.08);border:1px solid rgba(255,69,0,0.15);border-radius:14px;padding:14px;">
                <div style="font-size:26px;font-weight:800;color:#ff4500;">5</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Workouts</div>
            </div>
            <div style="text-align:center;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);border-radius:14px;padding:14px;">
                <div style="font-size:26px;font-weight:800;color:#10b981;">2</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Rest Days</div>
            </div>
            <div style="text-align:center;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);border-radius:14px;padding:14px;">
                <div style="font-size:22px;font-weight:800;color:#3b82f6;">PPL</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Split Type</div>
            </div>
        </div>
    </div>

    {{-- Tip --}}
    <div style="background:linear-gradient(135deg,#0d1a0d,#0a160a);border:1px solid rgba(16,185,129,0.2);border-radius:18px;padding:18px;display:flex;gap:12px;align-items:flex-start;margin-bottom:4px;">
        <div style="width:36px;height:36px;background:rgba(16,185,129,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">💡</div>
        <div>
            <div style="font-size:13px;font-weight:700;color:#10b981;margin-bottom:4px;">Schedule Tip</div>
            <div style="font-size:12px;color:#666;line-height:1.5;">Consistency beats intensity. Following your schedule 80% of the time is better than perfect plans you never execute. Stay committed!</div>
        </div>
    </div>

</div>

<script>
function showDay(index) {
    // Hide all cards
    for (let i = 0; i < 7; i++) {
        const card = document.getElementById('day-card-' + i);
        const btn = document.getElementById('day-btn-' + i);
        if (card) card.style.display = 'none';
        if (btn) {
            btn.style.background = 'transparent';
            btn.style.border = '1px solid transparent';
        }
    }
    // Show selected
    const selected = document.getElementById('day-card-' + index);
    const selectedBtn = document.getElementById('day-btn-' + index);
    if (selected) selected.style.display = 'block';
    if (selectedBtn) {
        selectedBtn.style.background = 'rgba(255,69,0,0.12)';
        selectedBtn.style.border = '1px solid rgba(255,69,0,0.3)';
    }
}
</script>
@endsection
