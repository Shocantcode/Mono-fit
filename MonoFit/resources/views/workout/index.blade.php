@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Workout</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">{{ now()->format('l, d F') }}</p>
    </div>

    {{-- Start Workout CTA --}}
    <div style="background:linear-gradient(135deg,#1a0800,#250d00);border:1px solid rgba(255,69,0,0.3);border-radius:20px;padding:22px;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;background:radial-gradient(circle,rgba(255,69,0,0.2) 0%,transparent 70%);pointer-events:none;"></div>
        <div style="font-size:40px;margin-bottom:10px;">⚡</div>
        <h2 style="font-size:20px;font-weight:800;color:#fff;margin-bottom:8px;">Ready to crush it?</h2>
        <p style="font-size:13px;color:#888;margin-bottom:20px;">Start your workout and track every rep, every set.</p>
        <button onclick="document.getElementById('log-modal').style.display='flex'" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px 32px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;width:100%;">
            + Log Today's Workout
        </button>
    </div>

    {{-- Exercise Categories --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Exercise Categories</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            @php
                $categories = [
                    ['icon'=>'💪','name'=>'Chest','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)'],
                    ['icon'=>'🦵','name'=>'Legs','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)'],
                    ['icon'=>'🏋️','name'=>'Back','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)'],
                    ['icon'=>'🤸','name'=>'Shoulders','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)'],
                    ['icon'=>'💨','name'=>'Cardio','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)'],
                    ['icon'=>'🧘','name'=>'Core','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)'],
                ];
            @endphp
            @foreach($categories as $cat)
            <div style="background:{{ $cat['color'] }};border:1px solid {{ $cat['border'] }};border-radius:14px;padding:14px;display:flex;align-items:center;gap:10px;cursor:pointer;">
                <span style="font-size:22px;">{{ $cat['icon'] }}</span>
                <span style="font-size:13px;font-weight:600;color:#fff;">{{ $cat['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Today's Plan --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Today's Plan</h3>
        @php
            $exercises = [
                ['name' => 'Bench Press', 'sets' => 4, 'reps' => '8-10', 'weight' => '60kg', 'icon' => '💪', 'done' => true],
                ['name' => 'Incline Dumbbell Press', 'sets' => 3, 'reps' => '10-12', 'weight' => '20kg', 'icon' => '💪', 'done' => true],
                ['name' => 'Cable Flyes', 'sets' => 3, 'reps' => '12-15', 'weight' => '15kg', 'icon' => '💪', 'done' => false],
                ['name' => 'Push-ups', 'sets' => 3, 'reps' => '20', 'weight' => 'BW', 'icon' => '🤸', 'done' => false],
                ['name' => 'Tricep Dips', 'sets' => 3, 'reps' => '12', 'weight' => 'BW', 'icon' => '💪', 'done' => false],
            ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($exercises as $ex)
            <div style="display:flex;align-items:center;gap:12px;background:{{ $ex['done'] ? 'rgba(16,185,129,0.06)' : 'rgba(255,255,255,0.03)' }};border:1px solid {{ $ex['done'] ? 'rgba(16,185,129,0.2)' : 'rgba(255,255,255,0.06)' }};border-radius:14px;padding:12px 14px;">
                <div style="width:38px;height:38px;background:rgba(255,69,0,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $ex['icon'] }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:{{ $ex['done'] ? '#888' : '#fff' }};text-decoration:{{ $ex['done'] ? 'line-through' : 'none' }};">{{ $ex['name'] }}</div>
                    <div style="font-size:11px;color:#555;margin-top:2px;">{{ $ex['sets'] }} sets · {{ $ex['reps'] }} reps · {{ $ex['weight'] }}</div>
                </div>
                <div style="width:26px;height:26px;border-radius:50%;background:{{ $ex['done'] ? 'rgba(16,185,129,0.2)' : 'rgba(255,255,255,0.05)' }};border:1px solid {{ $ex['done'] ? 'rgba(16,185,129,0.4)' : 'rgba(255,255,255,0.1)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    @if($ex['done'])
                        <svg width="13" height="13" fill="none" stroke="#10b981" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Progress bar --}}
        <div style="margin-top:16px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:12px;color:#666;">Progress</span>
                <span style="font-size:12px;color:#ff4500;font-weight:600;">2 / 5 done</span>
            </div>
            <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;">
                <div style="height:100%;width:40%;background:linear-gradient(90deg,#ff4500,#ff6a00);border-radius:3px;"></div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <a href="{{ route('exercises.index') }}" style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);border-radius:16px;padding:16px;text-decoration:none;display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;background:rgba(139,92,246,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">📚</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#fff;">Exercise Library</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">500+ exercises</div>
            </div>
        </a>
        <a href="{{ route('schedule.index') }}" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:16px;padding:16px;text-decoration:none;display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;background:rgba(245,158,11,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">📅</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#fff;">My Schedule</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">Weekly plan</div>
            </div>
        </a>
    </div>

    {{-- Recommended Workouts --}}
    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Recommended Programs</h3>
        @php
            $programs = [
                ['name'=>'Push Pull Legs','days'=>'6 days/week','level'=>'Intermediate','color'=>'#ff4500'],
                ['name'=>'5x5 Strength','days'=>'3 days/week','level'=>'Beginner','color'=>'#3b82f6'],
                ['name'=>'HIIT Burn','days'=>'4 days/week','level'=>'Advanced','color'=>'#10b981'],
            ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($programs as $prog)
            <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:14px;">
                <div style="width:4px;height:44px;background:{{ $prog['color'] }};border-radius:2px;flex-shrink:0;"></div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#fff;">{{ $prog['name'] }}</div>
                    <div style="font-size:12px;color:#555;margin-top:3px;">{{ $prog['days'] }} · {{ $prog['level'] }}</div>
                </div>
                <svg width="16" height="16" fill="none" stroke="#444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Log Workout Modal --}}
<div id="log-modal" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.8);align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#181818;border:1px solid rgba(255,255,255,0.1);border-radius:24px 24px 0 0;padding:28px 20px;width:100%;max-width:430px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;color:#fff;">Log Exercise</h3>
            <button onclick="document.getElementById('log-modal').style.display='none'" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <form action="{{ route('workout.store') }}" method="POST" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            <div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Exercise</label>
                <select id="exercise-select" name="exercise" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    <option value="">Select exercise</option>
                    <option value="Push-ups">Push-ups</option>
                    <option value="Squats">Squats</option>
                    <option value="Bench Press">Bench Press</option>
                    <option value="Dumbbell Row">Dumbbell Row</option>
                    <option value="Deadlift">Deadlift</option>
                    <option value="Plank">Plank</option>
                    <option value="Tricep Dips">Tricep Dips</option>
                    <option value="Bicep Curl">Bicep Curl</option>
                </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                <div>
                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Sets</label>
                    <input type="number" name="sets" placeholder="4" min="1" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Reps</label>
                    <input type="text" name="reps" placeholder="8-12" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
                <div>
                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Weight (kg)</label>
                    <input id="exercise-weight" type="number" name="weight" placeholder="60" step="0.5" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 10px;color:#fff;font-size:14px;text-align:center;outline:none;">
                </div>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;margin-top:4px;">
                Save Exercise
            </button>
        </form>
    </div>
</div>

<script>
    const exerciseSelect = document.getElementById('exercise-select');
    const weightInput = document.getElementById('exercise-weight');
    const bodyweightExercises = ['Push-ups', 'Squats', 'Plank'];

    function updateWeightField() {
        if (bodyweightExercises.includes(exerciseSelect.value)) {
            weightInput.value = '';
            weightInput.placeholder = 'Bodyweight';
            weightInput.readOnly = true;
            weightInput.style.opacity = '0.6';
        } else {
            weightInput.readOnly = false;
            weightInput.placeholder = 'kg';
            weightInput.style.opacity = '1';
        }
    }

    exerciseSelect.addEventListener('change', updateWeightField);
    updateWeightField();
</script>

@endsection
