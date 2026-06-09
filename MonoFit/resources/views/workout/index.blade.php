@extends('layouts.app')

@section('content')
<div style="padding: 20px; display: flex; flex-direction: column; gap: 18px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;">Workout</h1>
        <p style="font-size:13px;color:#666;margin-top:4px;">{{ $selectedDate->format('l, d F Y') }}</p>
    </div>

    @if(session('success'))
        <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:16px;padding:14px;color:#d7ffd9;">{{ session('success') }}</div>
    @endif

    <div style="display:grid;grid-template-columns:1fr;gap:14px;">
        <div style="background:linear-gradient(135deg,#1a0800,#250d00);border:1px solid rgba(255,69,0,0.3);border-radius:20px;padding:22px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-50px;right:-50px;width:150px;height:150px;background:radial-gradient(circle,rgba(255,69,0,0.2) 0%,transparent 70%);pointer-events:none;"></div>
            <div style="font-size:40px;margin-bottom:10px;">⚡</div>
            <h2 style="font-size:20px;font-weight:800;color:#fff;margin-bottom:8px;">Plan and log your workout</h2>
            <p style="font-size:13px;color:#888;margin-bottom:20px;">Choose a date, add exercises, and keep track of planned or finished workouts.</p>
            <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
                <button type="button" onclick="openWorkoutModal()" style="background:linear-gradient(135deg,#ff4500,#ff6a00);color:#fff;border:none;padding:14px 26px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;min-width:180px;">Add Workout</button>
                <a href="{{ route('exercises.index') }}" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#fff;text-decoration:none;padding:14px 26px;border-radius:12px;font-size:15px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;min-width:180px;">Browse Exercise Library</a>
            </div>
        </div>

        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;flex-wrap:wrap;">
                <div>
                    <div style="font-size:13px;color:#888;margin-bottom:6px;">Workout Schedule</div>
                    <div style="font-size:20px;font-weight:700;color:#fff;">{{ $calendarMonth->format('F Y') }}</div>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="{{ route('workout.index', ['date' => $calendarMonth->copy()->subMonth()->startOfMonth()->toDateString(), 'month' => $calendarMonth->copy()->subMonth()->month, 'year' => $calendarMonth->copy()->subMonth()->year]) }}" style="width:42px;height:42px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:18px;">←</a>
                    <a href="{{ route('workout.index', ['date' => $calendarMonth->copy()->addMonth()->startOfMonth()->toDateString(), 'month' => $calendarMonth->copy()->addMonth()->month, 'year' => $calendarMonth->copy()->addMonth()->year]) }}" style="width:42px;height:42px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:18px;">→</a>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:10px;text-align:center;margin-bottom:10px;font-size:12px;color:#888;">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px;">
                @foreach($calendarDays as $day)
                    @if(!$day)
                        <div style="height:72px;border-radius:18px;background:rgba(255,255,255,0.02);"></div>
                    @else
                        @php
                            $dayString = $day->format('Y-m-d');
                            $isSelected = $day->isSameDay($selectedDate);
                            $isToday = $day->isToday();
                            $hasWorkout = in_array($dayString, $monthWorkouts);
                        @endphp
                        <a href="{{ route('workout.index', ['date' => $dayString, 'month' => $calendarMonth->month, 'year' => $calendarMonth->year]) }}" style="display:block;min-height:72px;padding:12px;border-radius:18px;text-decoration:none;color:#fff;background:{{ $isSelected ? 'rgba(255,69,0,0.16)' : 'rgba(255,255,255,0.03)' }};border:1px solid {{ $isSelected ? 'rgba(255,69,0,0.35)' : 'rgba(255,255,255,0.06)' }};position:relative;">
                            <div style="font-size:14px;font-weight:700;">{{ $day->day }}</div>
                            @if($isToday)
                                <div style="position:absolute;bottom:12px;left:50%;transform:translateX(-50%);width:8px;height:8px;background:#10b981;border-radius:999px;"></div>
                            @elseif($hasWorkout)
                                <div style="position:absolute;bottom:12px;left:50%;transform:translateX(-50%);width:8px;height:8px;background:#f59e0b;border-radius:999px;"></div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                <div>
                    <h3 style="font-size:16px;font-weight:700;color:#fff;margin:0;">Workout for {{ $selectedDate->format('d M Y') }}</h3>
                    <p style="font-size:12px;color:#666;margin-top:6px;">Planned and finished workouts for the selected date.</p>
                </div>
                <button type="button" onclick="openWorkoutModal()" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#fff;padding:12px 18px;border-radius:14px;font-size:14px;cursor:pointer;">Add Exercise</button>
            </div>
            @if($selectedWorkout)
                <div style="margin-top:16px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.08);border-radius:18px;padding:18px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                        <div>
                            <div style="font-size:14px;color:#888;">Status</div>
                            <div style="font-size:17px;font-weight:700;color:{{ $selectedWorkout->completed ? '#10b981' : '#f59e0b' }};">{{ $selectedWorkout->completed ? 'Finished' : 'Planned' }}</div>
                        </div>
                        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                            @if($allExercisesCompleted && ! $dayFinished)
                                <form method="POST" action="{{ route('workout.day.status') }}" onsubmit="return confirm('Finish the day? This will count toward your streak if all exercises are completed.');">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                                    <input type="hidden" name="action" value="finish_day">
                                    <button type="submit" style="background:linear-gradient(135deg,#10b981,#14b8a6);border:none;color:#fff;padding:12px 18px;border-radius:14px;font-size:14px;cursor:pointer;">Finish Day</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($dayRest)
                        <div style="margin-top:14px;display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border-radius:14px;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);color:#10b981;">
                            <span>Rest day recorded for this date.</span>
                            <form method="POST" action="{{ route('workout.day.status.cancel') }}" style="margin:0;" onsubmit="return confirm('Cancel rest day? Streak will decrease by 1.');">
                                @csrf
                                <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                                <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:8px 12px;border-radius:10px;font-size:12px;cursor:pointer;">Cancel</button>
                            </form>
                        </div>
                    @elseif($dayFinished)
                        <div style="margin-top:14px;display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border-radius:14px;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);color:#38bdf8;">
                            <span>This day is finished and counted toward your streak.</span>
                            <form method="POST" action="{{ route('workout.day.status.cancel') }}" style="margin:0;" onsubmit="return confirm('Cancel finished day? Streak will decrease by 1.');">
                                @csrf
                                <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                                <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:8px 12px;border-radius:10px;font-size:12px;cursor:pointer;">Cancel</button>
                            </form>
                        </div>
                    @endif
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-top:18px;">
                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:14px;">
                            <div style="font-size:12px;color:#888;">Total Exercises</div>
                            <div style="font-size:18px;font-weight:700;color:#fff;">{{ count($selectedWorkout->exercises) }}</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:14px;">
                            <div style="font-size:12px;color:#888;">Total Sets</div>
                            <div style="font-size:18px;font-weight:700;color:#fff;">{{ $selectedWorkout->total_sets ?? 0 }}</div>
                        </div>
                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:14px;">
                            <div style="font-size:12px;color:#888;">Total Weight</div>
                            <div style="font-size:18px;font-weight:700;color:#fff;">{{ $selectedWorkout->total_weight ? number_format($selectedWorkout->total_weight, 1) . ' kg' : '-' }}</div>
                        </div>
                    </div>
                    <div style="margin-top:18px;display:flex;flex-direction:column;gap:14px;">
                        @foreach($selectedWorkoutExercises as $index => $exercise)
                            <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;padding:16px;">
                                <div style="display:flex;gap:12px;align-items:center;justify-content:space-between;">
                                    <div style="display:flex;gap:12px;align-items:center;flex:1;min-width:0;">
                                        <img src="{{ asset(str_replace(' ', '%20', $exercise['image_path'])) }}" alt="{{ $exercise['name'] }}" style="width:62px;height:62px;object-fit:cover;border-radius:16px;border:1px solid rgba(255,255,255,0.08);" />
                                        <div style="min-width:0;">
                                            <div style="font-size:14px;font-weight:700;color:#fff;">{{ $exercise['name'] }}</div>
                                            <div style="font-size:12px;color:#888;">{{ $exercise['category'] }} · {{ $exercise['equipment'] }}</div>
                                        </div>
                                    </div>
                                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;min-width:0;">
                                        <span style="font-size:12px;color:{{ $exercise['completed'] ? '#10b981' : '#fbbf24' }};font-weight:700;">{{ $exercise['completed'] ? 'Completed' : 'Pending' }}</span>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap;justify-content:flex-end;">
                                            <form method="POST" action="{{ route('workout.exercise.toggle', ['workout' => $selectedWorkout, 'index' => $index]) }}" style="margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" style="background:{{ $exercise['completed'] ? 'rgba(255,255,255,0.08)' : 'linear-gradient(135deg,#10b981,#14b8a6)' }};border:1px solid rgba(255,255,255,0.12);color:#fff;padding:8px 12px;border-radius:12px;font-size:12px;cursor:pointer;white-space:nowrap;">
                                                    {{ $exercise['completed'] ? 'Mark Pending' : 'Mark Completed' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('workout.exercise.delete', ['workout' => $selectedWorkout, 'index' => $index]) }}" onsubmit="return confirm('Delete this exercise from the workout?');" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:8px 12px;border-radius:12px;font-size:12px;cursor:pointer;white-space:nowrap;">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top:12px;display:flex;flex-wrap:wrap;gap:8px;">
                                    @foreach($exercise['sets'] as $set)
                                        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:10px 12px;min-width:100px;">
                                            <div style="font-size:12px;color:#888;">{{ $set['weight'] ?? 'Bodyweight' }}</div>
                                            <div style="font-size:14px;font-weight:700;color:#fff;">{{ $set['reps'] }} reps</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;">
                        <form method="POST" action="{{ route('workout.destroy', $selectedWorkout) }}" onsubmit="return confirm('Clear today plan? This will remove all exercises for this date.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:12px 18px;border-radius:14px;font-size:14px;cursor:pointer;">Clear Today Plan</button>
                        </form>
                    </div>
                </div>
            @else
                <div style="margin-top:16px;padding:18px;border:1px dashed rgba(255,255,255,0.12);border-radius:18px;color:#bbb;">
                    Tidak ada workout yang direncanakan untuk tanggal ini. Tambahkan latihan untuk mulai mencatat atau merencanakan sesi.
                </div>
                <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                    @if(! $dayRest && ! $dayFinished)
                        <form method="POST" action="{{ route('workout.day.status') }}" onsubmit="return confirm('Mark this date as a rest day?');">
                            @csrf
                            <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                            <input type="hidden" name="action" value="rest_day">
                            <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:12px 18px;border-radius:14px;font-size:14px;cursor:pointer;">Mark Rest Day</button>
                        </form>
                    @endif
                    @if($dayRest)
                        <div style="padding:12px 14px;border-radius:14px;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.15);color:#10b981;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                            <span>Rest day recorded for this date.</span>
                            <form method="POST" action="{{ route('workout.day.status.cancel') }}" style="margin:0;" onsubmit="return confirm('Cancel rest day? Streak will decrease by 1.');">
                                @csrf
                                <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                                <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:8px 12px;border-radius:10px;font-size:12px;cursor:pointer;">Cancel</button>
                            </form>
                        </div>
                    @elseif($dayFinished)
                        <div style="padding:12px 14px;border-radius:14px;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);color:#38bdf8;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                            <span>This day is finished and counted toward your streak.</span>
                            <form method="POST" action="{{ route('workout.day.status.cancel') }}" style="margin:0;" onsubmit="return confirm('Cancel finished day? Streak will decrease by 1.');">
                                @csrf
                                <input type="hidden" name="date" value="{{ $selectedDate->toDateString() }}">
                                <button type="submit" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.2);color:#f97316;padding:8px 12px;border-radius:10px;font-size:12px;cursor:pointer;">Cancel</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div style="background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
                <div>
                    <h3 style="font-size:16px;font-weight:700;color:#fff;margin:0;">Recommended Programs</h3>
                    <p style="font-size:12px;color:#666;margin-top:6px;">Programs matched to your current goal: {{ ucfirst(str_replace('_', ' ', $fitnessGoal)) }}.</p>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;">
                @foreach($recommendedPrograms as $program)
                    <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:18px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px;">
                            <div style="font-size:14px;font-weight:700;color:#fff;">{{ $program['title'] }}</div>
                            <div style="width:36px;height:36px;border-radius:14px;background:{{ $program['color'] }}33;display:flex;align-items:center;justify-content:center;color:{{ $program['color'] }};font-weight:700;">✓</div>
                        </div>
                        <div style="font-size:13px;color:#bbb;line-height:1.5;margin-bottom:12px;">{{ $program['desc'] }}</div>
                        <div style="font-size:12px;color:#888;">{{ $program['detail'] }}</div>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;">
                        <button type="button" onclick="openProgramExercise({{ $program['exercise_id'] }}, '{{ $selectedDate->toDateString() }}')" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#fff;padding:10px 14px;border-radius:14px;font-size:13px;cursor:pointer;">Add to Today Plan</button>
                        <button type="button" onclick="openProgramExercise({{ $program['exercise_id'] }})" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#fff;padding:10px 14px;border-radius:14px;font-size:13px;cursor:pointer;">Add to Plans</button>
                    </div>
                    </div>
                @endforeach
            </div>
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
                <input type="date" id="selected-date-input" name="selected_date" value="{{ $selectedDate->toDateString() }}" style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none;">
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
    const exerciseSelector = document.getElementById('exercise-selector');
    const selectedExercisePreview = document.getElementById('selected-exercise-preview');
    const exercisePreviewImage = document.getElementById('exercise-preview-image');
    const exercisePreviewCategory = document.getElementById('exercise-preview-category');
    const exercisePreviewEquipment = document.getElementById('exercise-preview-equipment');
    const exercisePreviewDescription = document.getElementById('exercise-preview-description');
    const recommendedReps = document.getElementById('recommended-reps');
    const setsTable = document.getElementById('sets-table');
    const addSetButton = document.getElementById('add-set-button');
    const logModal = document.getElementById('log-modal');
    let currentExerciseMeta = null;

    function getRecommendedRepText(difficulty) {
        if (!difficulty) {
            return '8-12 reps.';
        }
        const diff = difficulty.toLowerCase();
        if (diff.includes('beginner')) {
            return '10-15 reps.';
        }
        if (diff.includes('intermediate')) {
            return '8-12 reps.';
        }
        if (diff.includes('advanced')) {
            return '6-10 reps.';
        }
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
            name: selectedOption.textContent,
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

    function openProgramExercise(exerciseId, date = null) {
        openWorkoutModal(exerciseId);
        if (date) {
            document.getElementById('selected-date-input').value = date;
        }
    }

    function resetWorkoutModal() {
        logModal.style.display = 'none';
        exerciseSelector.value = '';
        selectedExercisePreview.style.display = 'none';
        setsTable.innerHTML = '';
        currentExerciseMeta = null;
    }

    exerciseSelector.addEventListener('change', syncSelectedExercise);
    addSetButton.addEventListener('click', () => {
        if (!exerciseSelector.value) {
            return;
        }
        addSetRow();
    });
</script>
@endsection
