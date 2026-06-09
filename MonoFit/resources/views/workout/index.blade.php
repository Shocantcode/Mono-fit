@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Workout</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">{{ now()->format('l, d F') }}</p>
    </div>

    @if(session('success'))
        <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:16px;padding:14px;color:#d7ffd9;">{{ session('success') }}</div>
    @endif

    <div style="background:linear-gradient(135deg,#1a0800,#250d00);border:1px solid rgba(255,69,0,0.3);border-radius:20px;padding:22px;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;background:radial-gradient(circle,rgba(255,69,0,0.2) 0%,transparent 70%);pointer-events:none;"></div>
        <div style="font-size:40px;margin-bottom:10px;">⚡</div>
        <h2 style="font-size:20px;font-weight:800;color:#fff;margin-bottom:8px;">Ready to log your next set?</h2>
        <p style="font-size:13px;color:#888;margin-bottom:20px;">Search your exercise, add sets, and finish your workout in one flow.</p>
        <button onclick="document.getElementById('exercise-list').scrollIntoView({ behavior: 'smooth', block: 'start' })" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px 32px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;width:100%;">
            + Log Today's Workout
        </button>
    </div>

    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Exercise Categories</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:10px;" id="category-buttons">
            <button type="button" class="category-button active" data-category="All" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;font-size:13px;color:#fff;cursor:pointer;">All</button>
            @foreach($categories as $category)
                <button type="button" class="category-button" data-category="{{ $category }}" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px;font-size:13px;color:#fff;cursor:pointer;">{{ $category }}</button>
            @endforeach
        </div>
    </div>

    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;flex-wrap:wrap;">
            <div>
                <h3 style="font-size:16px;font-weight:700;color:#fff;margin:0;">Exercise Library</h3>
                <p style="font-size:12px;color:#666;margin-top:4px;">Tap an exercise to start logging sets.</p>
            </div>
            <div style="flex:1;min-width:220px;">
                <input id="exercise-search" type="text" placeholder="Search exercises..." style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:13px;padding:13px 14px;color:#fff;font-size:14px;outline:none;" />
            </div>
        </div>

        <div id="exercise-list" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;">
            @foreach($exercises as $exercise)
                <button type="button" class="exercise-card" data-category="{{ $exercise->category }}" data-id="{{ $exercise->id }}" data-name="{{ $exercise->name }}" data-equipment="{{ $exercise->equipment }}" data-image="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" data-description="{{ $exercise->description }}" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:0;cursor:pointer;overflow:hidden;text-align:left;">
                    <div style="position:relative;height:160px;overflow:hidden;">
                        <img src="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" alt="{{ $exercise->name }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                        <div style="position:absolute;left:12px;top:12px;background:rgba(0,0,0,0.4);padding:6px 10px;border-radius:999px;font-size:12px;color:#fff;">{{ $exercise->category }}</div>
                    </div>
                    <div style="padding:14px;">
                        <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:6px;">{{ $exercise->name }}</div>
                        <div style="font-size:12px;color:#888;line-height:1.5;min-height:40px;">{{ $exercise->description }}</div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:12px;color:#aaa;">
                            <span>{{ $exercise->equipment }}</span>
                            <span>{{ $exercise->difficulty }}</span>
                        </div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    @php
        $workoutExercises = [];
        if ($workout) {
            $workoutExercises = is_array($workout->exercises)
                ? $workout->exercises
                : json_decode($workout->exercises ?? '[]', true) ?? [];
        }
    @endphp

    @if($workout && count($workoutExercises))
        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <h3 style="font-size:16px;font-weight:700;color:#fff;margin-bottom:14px;">Today's Workout Log</h3>
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($workoutExercises as $exercise)
                    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:14px;">
                        <div style="display:flex;gap:12px;align-items:center;">
                            <img src="{{ asset(str_replace(' ', '%20', $exercise['image_path'])) }}" alt="{{ $exercise['name'] }}" style="width:72px;height:72px;object-fit:cover;border-radius:16px;border:1px solid rgba(255,255,255,0.08);" />
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:14px;font-weight:700;color:#fff;">{{ $exercise['name'] }}</div>
                                <div style="font-size:12px;color:#888;">{{ $exercise['category'] }} · {{ $exercise['equipment'] }}</div>
                                <div style="font-size:12px;color:#aaa;margin-top:8px;">Logged at {{ \Carbon\Carbon::parse($exercise['logged_at'])->format('H:i') }}</div>
                            </div>
                        </div>
                        <div style="margin-top:14px;display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:10px;">
                            @foreach($exercise['sets'] as $index => $set)
                                <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:12px;">
                                    <div style="font-size:12px;color:#666;margin-bottom:6px;">Set {{ $index + 1 }}</div>
                                    <div style="font-size:13px;font-weight:700;color:#fff;">{{ $set['weight'] ?? '-' }}</div>
                                    <div style="font-size:12px;color:#888;margin-top:4px;">{{ $set['reps'] }} reps</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<div id="log-modal" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.8);align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#181818;border:1px solid rgba(255,255,255,0.1);border-radius:24px 24px 0 0;padding:28px 20px;width:100%;max-width:430px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;color:#fff;">Log Exercise</h3>
            <button type="button" onclick="resetWorkoutModal()" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <form action="{{ route('workout.store') }}" method="POST" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            <input type="hidden" id="exercise-id" name="exercise_id">

            <div>
                <label style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Exercise</label>
                <div id="exercise-name" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:12px 14px;color:#fff;font-size:14px;min-height:42px;display:flex;align-items:center;"></div>
            </div>

            <div id="selected-exercise-preview" style="display:none;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:14px;">
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <img id="exercise-preview-image" src="" alt="Exercise image" style="width:72px;height:72px;border-radius:16px;object-fit:cover;border:1px solid rgba(255,255,255,0.08);">
                    <div style="flex:1;">
                        <div id="exercise-preview-category" style="font-size:12px;color:#888;margin-bottom:6px;"></div>
                        <div id="exercise-preview-equipment" style="font-size:13px;color:#fff;font-weight:700;"></div>
                        <div id="exercise-preview-description" style="font-size:12px;color:#aaa;margin-top:6px;"></div>
                    </div>
                </div>
            </div>

            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#fff;">Sets</div>
                        <div style="font-size:11px;color:#666;margin-top:2px;">Tambahkan set lalu isi berat dan repetisi.</div>
                    </div>
                    <button type="button" id="add-set-button" style="background:rgba(255,255,255,0.08);border:none;color:#fff;padding:8px 14px;border-radius:12px;font-size:13px;cursor:pointer;">Add Set</button>
                </div>
                <div id="sets-table" style="display:flex;flex-direction:column;gap:10px;"></div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <button type="submit" style="flex:1;background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;">Finish Workout</button>
                <button type="button" onclick="resetWorkoutModal()" style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);color:#fff;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;">Discard</button>
            </div>
        </form>
    </div>
</div>

<script>
    const exerciseCards = document.querySelectorAll('.exercise-card');
    const categoryButtons = document.querySelectorAll('.category-button');
    const exerciseSearch = document.getElementById('exercise-search');
    const logModal = document.getElementById('log-modal');
    const exerciseIdInput = document.getElementById('exercise-id');
    const exerciseNameLabel = document.getElementById('exercise-name');
    const exercisePreview = document.getElementById('selected-exercise-preview');
    const exercisePreviewImage = document.getElementById('exercise-preview-image');
    const exercisePreviewCategory = document.getElementById('exercise-preview-category');
    const exercisePreviewEquipment = document.getElementById('exercise-preview-equipment');
    const exercisePreviewDescription = document.getElementById('exercise-preview-description');
    const setsTable = document.getElementById('sets-table');
    const addSetButton = document.getElementById('add-set-button');
    let currentExercise = null;

    function filterExercises() {
        const searchTerm = exerciseSearch.value.toLowerCase();
        const activeCategory = document.querySelector('.category-button.active')?.dataset.category || 'All';

        exerciseCards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const category = card.dataset.category;
            const matchesSearch = name.includes(searchTerm);
            const matchesCategory = activeCategory === 'All' || category === activeCategory;
            card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
        });
    }

    exerciseSearch.addEventListener('input', filterExercises);

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            filterExercises();
        });
    });

    exerciseCards.forEach(card => {
        card.addEventListener('click', () => {
            const exercise = {
                id: card.dataset.id,
                name: card.dataset.name,
                equipment: card.dataset.equipment,
                image: card.dataset.image,
                category: card.dataset.category,
                description: card.dataset.description,
            };
            openExerciseModal(exercise);
        });
    });

    function openExerciseModal(exercise) {
        currentExercise = exercise;
        logModal.style.display = 'flex';
        exerciseIdInput.value = exercise.id;
        exerciseNameLabel.textContent = exercise.name;
        exercisePreview.style.display = 'block';
        exercisePreviewImage.src = exercise.image;
        exercisePreviewCategory.textContent = exercise.category;
        exercisePreviewEquipment.textContent = exercise.equipment;
        exercisePreviewDescription.textContent = exercise.description;
        setsTable.innerHTML = '';
        addSetRow();
        updateSetInputs();
    }

    function resetWorkoutModal() {
        logModal.style.display = 'none';
        currentExercise = null;
        exerciseIdInput.value = '';
        exerciseNameLabel.textContent = '';
        exercisePreview.style.display = 'none';
        setsTable.innerHTML = '';
        exerciseSearch.value = '';
        filterExercises();
    }

    function addSetRow(weight = '', reps = '') {
        const row = document.createElement('div');
        row.style.display = 'grid';
        row.style.gridTemplateColumns = '1fr 1fr 40px';
        row.style.gap = '10px';
        row.style.alignItems = 'center';

        const weightInput = document.createElement('input');
        weightInput.type = 'number';
        weightInput.name = 'set_weight[]';
        weightInput.placeholder = currentExercise && currentExercise.equipment === 'Bodyweight' ? 'Bodyweight' : 'Weight';
        weightInput.value = weight;
        weightInput.style.width = '100%';
        weightInput.style.background = 'rgba(255,255,255,0.06)';
        weightInput.style.border = '1px solid rgba(255,255,255,0.1)';
        weightInput.style.borderRadius = '12px';
        weightInput.style.padding = '12px 10px';
        weightInput.style.color = '#fff';
        weightInput.style.fontSize = '14px';
        weightInput.style.outline = 'none';
        weightInput.step = '0.5';
        if (currentExercise && currentExercise.equipment === 'Bodyweight') {
            weightInput.readOnly = true;
            weightInput.value = '';
            weightInput.placeholder = 'Bodyweight';
            weightInput.style.opacity = '0.6';
        }

        const repsInput = document.createElement('input');
        repsInput.type = 'text';
        repsInput.name = 'set_reps[]';
        repsInput.placeholder = 'Reps';
        repsInput.value = reps;
        repsInput.style.width = '100%';
        repsInput.style.background = 'rgba(255,255,255,0.06)';
        repsInput.style.border = '1px solid rgba(255,255,255,0.1)';
        repsInput.style.borderRadius = '12px';
        repsInput.style.padding = '12px 10px';
        repsInput.style.color = '#fff';
        repsInput.style.fontSize = '14px';
        repsInput.style.outline = 'none';

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = '✕';
        deleteButton.style.width = '40px';
        deleteButton.style.height = '40px';
        deleteButton.style.border = '1px solid rgba(255,255,255,0.1)';
        deleteButton.style.borderRadius = '12px';
        deleteButton.style.background = 'rgba(255,255,255,0.06)';
        deleteButton.style.color = '#fff';
        deleteButton.style.cursor = 'pointer';

        deleteButton.addEventListener('click', () => {
            row.remove();
            if (!setsTable.children.length) {
                addSetRow();
            }
        });

        row.appendChild(weightInput);
        row.appendChild(repsInput);
        row.appendChild(deleteButton);
        setsTable.appendChild(row);
    }

    addSetButton.addEventListener('click', () => {
        if (!currentExercise) {
            return;
        }
        addSetRow();
    });

    function updateSetInputs() {
        const inputs = setsTable.querySelectorAll('input[name="set_weight[]"]');
        if (!currentExercise) {
            return;
        }
        inputs.forEach(input => {
            if (currentExercise.equipment === 'Bodyweight') {
                input.readOnly = true;
                input.value = '';
                input.placeholder = 'Bodyweight';
                input.style.opacity = '0.6';
            } else {
                input.readOnly = false;
                input.placeholder = 'Weight';
                input.style.opacity = '1';
            }
        });
    }

    filterExercises();
</script>
@endsection
