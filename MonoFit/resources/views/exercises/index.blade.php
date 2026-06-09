@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:14px;">
        <a href="{{ route('workout.index') }}" style="width:36px;height:36px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;">
            <svg width="16" height="16" fill="none" stroke="#aaa" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Exercise Library</h1>
            <p style="font-size:13px;color:#666;margin-top:2px;">500+ exercises across all muscle groups</p>
        </div>
    </div>

    {{-- Search --}}
    <div style="position:relative;">
        <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);pointer-events:none;">
            <svg width="16" height="16" fill="none" stroke="#555" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="text" id="exercise-search" placeholder="Search exercises..." oninput="filterExercises()" style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:13px;padding:13px 14px 13px 42px;color:#fff;font-size:14px;font-family:'Figtree',sans-serif;outline:none;">
    </div>

    {{-- Category Filters --}}
    <div style="display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;scrollbar-width:none;">
        @php
            $cats = ['All','Chest','Back','Legs','Shoulders','Arms','Core','Cardio','Glutes'];
        @endphp
        @foreach($cats as $i => $cat)
        <button onclick="setCategory('{{ $cat }}')" id="cat-{{ $cat }}" style="flex-shrink:0;padding:8px 16px;border-radius:50px;border:1px solid {{ $i === 0 ? '#ff4500' : 'rgba(255,255,255,0.09)' }};background:{{ $i === 0 ? 'rgba(255,69,0,0.15)' : 'rgba(255,255,255,0.04)' }};color:{{ $i === 0 ? '#ff4500' : '#777' }};font-size:13px;font-weight:600;cursor:pointer;font-family:'Figtree',sans-serif;white-space:nowrap;">{{ $cat }}</button>
        @endforeach
    </div>

    {{-- Exercise Count --}}
    <p id="exercise-count" style="font-size:12px;color:#555;">Showing all exercises</p>

    {{-- Exercise List --}}
    <div id="exercise-list" style="display:flex;flex-direction:column;gap:10px;">
        @php
            $exercises = [
                // Chest
                ['name'=>'Bench Press','category'=>'Chest','muscle'=>'Pectoralis Major','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'💪','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)','desc'=>'Lie on a bench and press the barbell upward. Classic compound chest exercise.'],
                ['name'=>'Incline Dumbbell Press','category'=>'Chest','muscle'=>'Upper Chest','difficulty'=>'Intermediate','equipment'=>'Dumbbells','emoji'=>'💪','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)','desc'=>'Press dumbbells on an inclined bench to target the upper pecs.'],
                ['name'=>'Push-Ups','category'=>'Chest','muscle'=>'Pectoralis Major','difficulty'=>'Beginner','equipment'=>'Bodyweight','emoji'=>'🤸','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)','desc'=>'Classic bodyweight exercise. Great for chest, shoulders, and triceps.'],
                ['name'=>'Cable Flyes','category'=>'Chest','muscle'=>'Pectoralis Major','difficulty'=>'Intermediate','equipment'=>'Cable Machine','emoji'=>'💪','color'=>'rgba(255,69,0,0.1)','border'=>'rgba(255,69,0,0.2)','desc'=>'Isolate the chest with a wide-arc cable movement for maximum stretch.'],
                // Back
                ['name'=>'Pull-Ups','category'=>'Back','muscle'=>'Latissimus Dorsi','difficulty'=>'Intermediate','equipment'=>'Pull-up Bar','emoji'=>'🏋️','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)','desc'=>'Hang from a bar and pull your body up. One of the best back exercises.'],
                ['name'=>'Barbell Row','category'=>'Back','muscle'=>'Rhomboids, Lats','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'🏋️','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)','desc'=>'Bend over and row the barbell to your lower chest for a thick back.'],
                ['name'=>'Lat Pulldown','category'=>'Back','muscle'=>'Latissimus Dorsi','difficulty'=>'Beginner','equipment'=>'Cable Machine','emoji'=>'🏋️','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)','desc'=>'Pull the bar down to your chest to build wide lats.'],
                ['name'=>'Deadlift','category'=>'Back','muscle'=>'Full Posterior Chain','difficulty'=>'Advanced','equipment'=>'Barbell','emoji'=>'🏋️','color'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.2)','desc'=>'The king of compound movements. Builds total body strength.'],
                // Legs
                ['name'=>'Back Squat','category'=>'Legs','muscle'=>'Quadriceps, Glutes','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'🦵','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)','desc'=>'Barbell on your back, squat deep. Builds massive leg strength.'],
                ['name'=>'Romanian Deadlift','category'=>'Legs','muscle'=>'Hamstrings, Glutes','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'🦵','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)','desc'=>'Hinge at the hips with a slight knee bend to target hamstrings.'],
                ['name'=>'Leg Press','category'=>'Legs','muscle'=>'Quadriceps','difficulty'=>'Beginner','equipment'=>'Machine','emoji'=>'🦵','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)','desc'=>'Push a weighted platform away from you to build quad size.'],
                ['name'=>'Walking Lunges','category'=>'Legs','muscle'=>'Quads, Glutes, Hams','difficulty'=>'Beginner','equipment'=>'Bodyweight','emoji'=>'🦵','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)','desc'=>'Step forward into a lunge alternating legs. Great for balance and strength.'],
                // Shoulders
                ['name'=>'Overhead Press','category'=>'Shoulders','muscle'=>'Deltoids','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'🤸','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)','desc'=>'Press the barbell overhead from shoulders. Builds boulder shoulders.'],
                ['name'=>'Lateral Raises','category'=>'Shoulders','muscle'=>'Lateral Deltoids','difficulty'=>'Beginner','equipment'=>'Dumbbells','emoji'=>'🤸','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)','desc'=>'Raise dumbbells to your sides to target the medial head of the delts.'],
                ['name'=>'Arnold Press','category'=>'Shoulders','muscle'=>'All 3 Delt Heads','difficulty'=>'Intermediate','equipment'=>'Dumbbells','emoji'=>'🤸','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)','desc'=>'Rotate as you press to hit all three heads of the deltoid.'],
                // Arms
                ['name'=>'Barbell Curl','category'=>'Arms','muscle'=>'Biceps','difficulty'=>'Beginner','equipment'=>'Barbell','emoji'=>'💪','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)','desc'=>'Classic bicep curl with a barbell for maximum overload.'],
                ['name'=>'Tricep Dips','category'=>'Arms','muscle'=>'Triceps','difficulty'=>'Beginner','equipment'=>'Bodyweight','emoji'=>'💪','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)','desc'=>'Lower and raise your body using parallel bars. Great tricep builder.'],
                ['name'=>'Hammer Curl','category'=>'Arms','muscle'=>'Biceps, Brachialis','difficulty'=>'Beginner','equipment'=>'Dumbbells','emoji'=>'💪','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)','desc'=>'Curl with a neutral grip to target the brachialis for arm thickness.'],
                ['name'=>'Skull Crushers','category'=>'Arms','muscle'=>'Triceps','difficulty'=>'Intermediate','equipment'=>'EZ Bar','emoji'=>'💪','color'=>'rgba(139,92,246,0.1)','border'=>'rgba(139,92,246,0.2)','desc'=>'Lower the bar to your forehead and extend for a great tricep stretch.'],
                // Core
                ['name'=>'Plank','category'=>'Core','muscle'=>'Core, Abs','difficulty'=>'Beginner','equipment'=>'Bodyweight','emoji'=>'🧘','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)','desc'=>'Hold a push-up position. Builds core stability and endurance.'],
                ['name'=>'Cable Crunch','category'=>'Core','muscle'=>'Rectus Abdominis','difficulty'=>'Beginner','equipment'=>'Cable Machine','emoji'=>'🧘','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)','desc'=>'Crunch downward using a cable attachment to really isolate the abs.'],
                ['name'=>'Hanging Leg Raise','category'=>'Core','muscle'=>'Lower Abs, Hip Flexors','difficulty'=>'Intermediate','equipment'=>'Pull-up Bar','emoji'=>'🧘','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)','desc'=>'Hang and raise your legs to 90 degrees for lower ab development.'],
                // Cardio
                ['name'=>'Treadmill Run','category'=>'Cardio','muscle'=>'Full Body','difficulty'=>'Beginner','equipment'=>'Treadmill','emoji'=>'💨','color'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)','desc'=>'Steady-state running for cardiovascular endurance and calorie burn.'],
                ['name'=>'Jump Rope','category'=>'Cardio','muscle'=>'Calves, Shoulders','difficulty'=>'Beginner','equipment'=>'Jump Rope','emoji'=>'💨','color'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)','desc'=>'Jump rope for high-calorie burn and coordination training.'],
                ['name'=>'Burpees','category'=>'Cardio','muscle'=>'Full Body','difficulty'=>'Intermediate','equipment'=>'Bodyweight','emoji'=>'💨','color'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)','desc'=>'Drop, push-up, stand, jump. Full-body HIIT exercise for cardio and strength.'],
                ['name'=>'Rowing Machine','category'=>'Cardio','muscle'=>'Back, Arms, Legs','difficulty'=>'Beginner','equipment'=>'Rowing Machine','emoji'=>'💨','color'=>'rgba(6,182,212,0.1)','border'=>'rgba(6,182,212,0.2)','desc'=>'Low-impact cardio that also works back, arms, and legs simultaneously.'],
                // Glutes
                ['name'=>'Hip Thrust','category'=>'Glutes','muscle'=>'Gluteus Maximus','difficulty'=>'Intermediate','equipment'=>'Barbell','emoji'=>'🍑','color'=>'rgba(251,146,60,0.1)','border'=>'rgba(251,146,60,0.2)','desc'=>'Drive your hips upward with a barbell across your hips. Best glute exercise.'],
                ['name'=>'Glute Kickbacks','category'=>'Glutes','muscle'=>'Gluteus Maximus','difficulty'=>'Beginner','equipment'=>'Cable Machine','emoji'=>'🍑','color'=>'rgba(251,146,60,0.1)','border'=>'rgba(251,146,60,0.2)','desc'=>'Kick your leg back against cable resistance to isolate the glutes.'],
                ['name'=>'Sumo Squat','category'=>'Glutes','muscle'=>'Glutes, Inner Thighs','difficulty'=>'Beginner','equipment'=>'Dumbbells','emoji'=>'🍑','color'=>'rgba(251,146,60,0.1)','border'=>'rgba(251,146,60,0.2)','desc'=>'Wide stance squat that targets glutes and inner thighs more than regular squat.'],
            ];
            $exercises = array_map(function($item) {
                return array_merge(['image' => 'placeholder.gif'], $item);
            }, $exercises);
        @endphp

        @foreach($exercises as $ex)
        <div class="exercise-card"
             data-category="{{ $ex['category'] }}"
             data-name="{{ strtolower($ex['name']) }} {{ strtolower($ex['muscle']) }}"
             style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:16px;padding:16px;display:flex;gap:14px;align-items:flex-start;">
            <div style="width:46px;height:46px;background:{{ $ex['color'] }};border:1px solid {{ $ex['border'] }};border-radius:13px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                <img src="{{ asset('images/exercises/' . $ex['image']) }}" alt="{{ $ex['name'] }}" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;" />
            </div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                    <div style="font-size:15px;font-weight:700;color:#fff;">{{ $ex['name'] }}</div>
                    <span style="flex-shrink:0;font-size:10px;font-weight:700;padding:3px 8px;border-radius:50px;background:{{ $ex['difficulty'] === 'Beginner' ? 'rgba(16,185,129,0.12)' : ($ex['difficulty'] === 'Advanced' ? 'rgba(239,68,68,0.12)' : 'rgba(245,158,11,0.12)') }};color:{{ $ex['difficulty'] === 'Beginner' ? '#10b981' : ($ex['difficulty'] === 'Advanced' ? '#ef4444' : '#f59e0b') }};">{{ $ex['difficulty'] }}</span>
                </div>
                <div style="font-size:12px;color:#555;margin-top:3px;">{{ $ex['muscle'] }} · {{ $ex['equipment'] }}</div>
                <div style="font-size:12px;color:#666;margin-top:6px;line-height:1.5;">{{ $ex['desc'] }}</div>
                <div style="margin-top:10px;display:flex;gap:8px;">
                    <span style="font-size:11px;font-weight:600;color:#ff4500;background:rgba(255,69,0,0.1);border-radius:6px;padding:3px 8px;">{{ $ex['category'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script>
let currentCategory = 'All';

function setCategory(cat) {
    currentCategory = cat;
    // Update button styles
    document.querySelectorAll('[id^="cat-"]').forEach(btn => {
        btn.style.borderColor = 'rgba(255,255,255,0.09)';
        btn.style.background = 'rgba(255,255,255,0.04)';
        btn.style.color = '#777';
    });
    const activeBtn = document.getElementById('cat-' + cat);
    if (activeBtn) {
        activeBtn.style.borderColor = '#ff4500';
        activeBtn.style.background = 'rgba(255,69,0,0.15)';
        activeBtn.style.color = '#ff4500';
    }
    filterExercises();
}

function filterExercises() {
    const query = document.getElementById('exercise-search').value.toLowerCase();
    const cards = document.querySelectorAll('.exercise-card');
    let visible = 0;

    cards.forEach(card => {
        const catMatch = currentCategory === 'All' || card.dataset.category === currentCategory;
        const nameMatch = !query || card.dataset.name.includes(query);
        if (catMatch && nameMatch) {
            card.style.display = 'flex';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    const countEl = document.getElementById('exercise-count');
    countEl.textContent = visible + ' exercise' + (visible !== 1 ? 's' : '') + (currentCategory !== 'All' ? ' in ' + currentCategory : '') + (query ? ' matching "' + query + '"' : '');
}

// Init count
filterExercises();
</script>
@endsection
