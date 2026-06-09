@extends('layouts.app')

@section('content')
<style>
    .category-button.active {
        border: 2px solid #ff4500 !important;
        background: rgba(255,69,0,0.1) !important;
    }
    .category-button:not(.active) {
        border: 2px solid transparent !important;
        background: rgba(255,255,255,0.05) !important;
    }
</style>
<div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
    <div>
        <h1 style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Exercise Library</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">Explore exercises with GIF previews and filter by category.</p>
    </div>

    <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;display:flex;flex-direction:column;gap:18px;">
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <input id="exercise-search" type="text" placeholder="Search exercises..." value="{{ $search ?? '' }}" style="flex:1;min-width:220px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:13px;padding:13px 14px;color:#fff;font-size:14px;font-family:'Figtree',sans-serif;outline:none;" />
            <button type="button" onclick="filterExercises()" style="background:linear-gradient(135deg,#ff4500,#ff6a00);border:none;color:#fff;padding:13px 18px;border-radius:13px;font-size:14px;cursor:pointer;">Search</button>
        </div>

        <div id="category-buttons" style="display:flex;flex-wrap:wrap;gap:10px;">
            <button type="button" class="category-button active" data-category="All" style="border:2px solid #ff4500;background:rgba(255,69,0,0.1);color:#fff;padding:10px 16px;border-radius:999px;cursor:pointer;font-size:13px;">All</button>
            @foreach($categories as $category)
                <button type="button" class="category-button" data-category="{{ $category }}" style="border:2px solid transparent;background:rgba(255,255,255,0.05);color:#fff;padding:10px 16px;border-radius:999px;cursor:pointer;font-size:13px;transition:all 0.2s;">{{ $category }}</button>
            @endforeach
        </div>

        <div id="exercise-results" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;">
            @foreach($exercises as $exercise)
                <div class="exercise-card" data-name="{{ strtolower($exercise->name) }}" data-category="{{ $exercise->category }}" data-id="{{ $exercise->id }}" data-image="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" data-category="{{ $exercise->category }}" data-description="{{ $exercise->description }}" data-equipment="{{ $exercise->equipment }}" data-difficulty="{{ $exercise->difficulty }}" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:20px;overflow:hidden;">
                    <div style="position:relative;height:160px;overflow:hidden;">
                        <img src="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" alt="{{ $exercise->name }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                        <div style="position:absolute;left:12px;top:12px;background:rgba(0,0,0,0.45);padding:6px 10px;border-radius:999px;font-size:12px;color:#fff;">{{ $exercise->category }}</div>
                    </div>
                    <div style="padding:16px;display:flex;flex-direction:column;gap:12px;">
                        <div>
                            <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:6px;">{{ $exercise->name }}</div>
                            <div style="font-size:12px;color:#888;line-height:1.5;height:42px;overflow:hidden;">{{ $exercise->description }}</div>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#aaa;">
                            <span>{{ $exercise->equipment }}</span>
                            <span>{{ $exercise->difficulty }}</span>
                        </div>
                        <button type="button" class="add-exercise-button" data-id="{{ $exercise->id }}" style="background:linear-gradient(135deg,#ff4500,#ff6a00);border:none;color:#fff;padding:12px 14px;border-radius:14px;font-size:13px;cursor:pointer;">Add</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="log-modal" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.8);align-items:flex-end;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#181818;border:1px solid rgba(255,255,255,0.1);border-radius:24px 24px 0 0;padding:28px 20px;width:100%;max-width:460px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#fff;margin:0;">Add Workout</h3>
                <p style="font-size:12px;color:#666;margin-top:4px;">Pick an exercise, add sets, and save it as planned or finished.</p>
            </div>
            <button type="button" onclick="resetWorkoutModal()" style="background:rgba(255,255,255,0.08);border:none;color:#aaa;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <form action="{{ route('workout.store') }}" method="POST" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            <div>
                <label for="selected-date-input" style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Date</label>
                <input type="date" id="selected-date-input" name="selected_date" value="{{ now()->toDateString() }}" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
            </div>
            <div>
                <label for="exercise-selector" style="font-size:12px;color:#666;display:block;margin-bottom:6px;">Exercise</label>
                <select id="exercise-selector" name="exercise_id" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
                    <option value="">Select exercise</option>
                    @foreach($exercises as $exercise)
                        <option value="{{ $exercise->id }}" data-image="{{ asset(str_replace(' ', '%20', $exercise->image_path)) }}" data-category="{{ $exercise->category }}" data-equipment="{{ $exercise->equipment }}" data-description="{{ $exercise->description }}" data-difficulty="{{ $exercise->difficulty }}">{{ $exercise->name }} ({{ $exercise->category }})</option>
                    @endforeach
                </select>
            </div>
            <div id="selected-exercise-preview" style="display:none;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:14px;">
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <img id="exercise-preview-image" src="" alt="Exercise image" style="width:72px;height:72px;border-radius:16px;object-fit:cover;border:1px solid rgba(255,255,255,0.08);">
                    <div style="flex:1;">
                        <div id="exercise-preview-category" style="font-size:12px;color:#888;margin-bottom:6px;"></div>
                        <div id="exercise-preview-equipment" style="font-size:13px;color:#fff;font-weight:700;"></div>
                        <div id="exercise-preview-description" style="font-size:12px;color:#aaa;margin-top:6px;"></div>
                        <div id="recommended-reps" style="font-size:12px;color:#bbb;margin-top:8px;"></div>
                    </div>
                </div>
            </div>
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#fff;">Sets</div>
                        <div style="font-size:11px;color:#666;margin-top:2px;">Add sets and choose weight/reps per set.</div>
                    </div>
                    <button type="button" id="add-set-button" style="background:rgba(255,255,255,0.08);border:none;color:#fff;padding:8px 14px;border-radius:12px;font-size:13px;cursor:pointer;">Add Set</button>
                </div>
                <div id="sets-table" style="display:flex;flex-direction:column;gap:10px;"></div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <button type="submit" name="plan_action" value="plan" style="flex:1;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:#fff;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;">Add Plans</button>
                <button type="submit" name="plan_action" value="finish" style="flex:1;background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;">Add to Finished Workout</button>
            </div>
        </form>
    </div>
</div>

<script>
    const exerciseSearch = document.getElementById('exercise-search');
    const categoryButtons = document.querySelectorAll('.category-button');
    const exerciseCards = document.querySelectorAll('.exercise-card');
    const logModal = document.getElementById('log-modal');
    const exerciseSelector = document.getElementById('exercise-selector');
    const selectedExercisePreview = document.getElementById('selected-exercise-preview');
    const exercisePreviewImage = document.getElementById('exercise-preview-image');
    const exercisePreviewCategory = document.getElementById('exercise-preview-category');
    const exercisePreviewEquipment = document.getElementById('exercise-preview-equipment');
    const exercisePreviewDescription = document.getElementById('exercise-preview-description');
    const recommendedReps = document.getElementById('recommended-reps');
    const addSetButton = document.getElementById('add-set-button');
    const setsTable = document.getElementById('sets-table');
    let currentExerciseMeta = null;

    function filterExercises() {
        const term = exerciseSearch.value.toLowerCase();
        const activeCategory = document.querySelector('.category-button.active')?.dataset.category || 'All';

        exerciseCards.forEach(card => {
            const name = card.dataset.name;
            const category = card.dataset.category;
            const matchesSearch = name.includes(term);
            const matchesCategory = activeCategory === 'All' || category === activeCategory;
            card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
        });
    }

    function getRecommendedRepText(difficulty) {
        if (!difficulty) return '8-12 reps.';
        const diff = difficulty.toLowerCase();
        if (diff.includes('beginner')) return '10-15 reps.';
        if (diff.includes('intermediate')) return '8-12 reps.';
        if (diff.includes('advanced')) return '6-10 reps.';
        return '8-12 reps.';
    }

    function syncSelectedExercise() {
        const selectedOption = exerciseSelector.selectedOptions[0];
        if (!selectedOption || !selectedOption.value) {
            selectedExercisePreview.style.display = 'none';
            currentExerciseMeta = null;
            return;
        }

        currentExerciseMeta = {
            id: selectedOption.value,
            image: selectedOption.dataset.image,
            category: selectedOption.dataset.category,
            equipment: selectedOption.dataset.equipment,
            description: selectedOption.dataset.description,
            difficulty: selectedOption.dataset.difficulty,
        };

        exercisePreviewImage.src = currentExerciseMeta.image;
        exercisePreviewCategory.textContent = currentExerciseMeta.category;
        exercisePreviewEquipment.textContent = currentExerciseMeta.equipment + ' · ' + currentExerciseMeta.difficulty;
        exercisePreviewDescription.textContent = currentExerciseMeta.description;
        recommendedReps.textContent = 'Recommended: ' + getRecommendedRepText(currentExerciseMeta.difficulty);
        selectedExercisePreview.style.display = 'block';
        updateWeightPlaceholders();
    }

    function updateWeightPlaceholders() {
        document.querySelectorAll('input[name="set_weight[]"]').forEach(input => {
            if (currentExerciseMeta && currentExerciseMeta.equipment.toLowerCase().includes('bodyweight')) {
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

    function addSetRow(weight = '', reps = '') {
        const row = document.createElement('div');
        row.style.display = 'grid';
        row.style.gridTemplateColumns = '1fr 1fr 40px';
        row.style.gap = '10px';
        row.style.alignItems = 'center';

        const weightInput = document.createElement('input');
        weightInput.type = 'number';
        weightInput.name = 'set_weight[]';
        weightInput.placeholder = currentExerciseMeta && currentExerciseMeta.equipment.toLowerCase().includes('bodyweight') ? 'Bodyweight' : 'Weight';
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
        if (currentExerciseMeta && currentExerciseMeta.equipment.toLowerCase().includes('bodyweight')) {
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

    function openWorkoutModal(exerciseId = null) {
        logModal.style.display = 'flex';
        if (exerciseId) {
            exerciseSelector.value = exerciseId;
            syncSelectedExercise();
        }
        if (!setsTable.children.length) {
            addSetRow();
        }
    }

    function resetWorkoutModal() {
        logModal.style.display = 'none';
        exerciseSelector.value = '';
        selectedExercisePreview.style.display = 'none';
        setsTable.innerHTML = '';
        currentExerciseMeta = null;
    }

    document.querySelectorAll('.add-exercise-button').forEach(button => {
        button.addEventListener('click', () => {
            openWorkoutModal(button.dataset.id);
        });
    });

    exerciseSelector.addEventListener('change', syncSelectedExercise);
    exerciseSearch.addEventListener('input', filterExercises);
    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            filterExercises();
        });
    });
    addSetButton.addEventListener('click', () => {
        if (!exerciseSelector.value) return;
        addSetRow();
    });

    filterExercises();
</script>
@endsection
