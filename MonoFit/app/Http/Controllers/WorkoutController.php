<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->query('date') ? Carbon::parse($request->query('date')) : today();
        $selectedDate = $selectedDate->copy()->startOfDay();

        $calendarMonth = $request->query('month') && $request->query('year')
            ? Carbon::createFromDate((int) $request->query('year'), (int) $request->query('month'), 1)
            : $selectedDate->copy()->startOfMonth();

        $selectedWorkout = $user->workouts()->whereDate('date', $selectedDate)->first();

        $exercises = Exercise::orderBy('category')->orderBy('name')->get();
        $categories = Exercise::select('category')->distinct()->pluck('category');

        $monthWorkouts = $user->workouts()
            ->whereYear('date', $calendarMonth->year)
            ->whereMonth('date', $calendarMonth->month)
            ->pluck('date')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->toArray();

        $calendarDays = [];
        $firstDayOfMonth = $calendarMonth->copy()->startOfMonth();
        $leadingEmpty = $firstDayOfMonth->dayOfWeek;
        for ($i = 0; $i < $leadingEmpty; $i++) {
            $calendarDays[] = null;
        }
        for ($day = 1; $day <= $calendarMonth->daysInMonth; $day++) {
            $calendarDays[] = $calendarMonth->copy()->day($day);
        }

        $programGoals = [
            'maintenance' => [
                [
                    'title' => 'Balanced Maintenance',
                    'desc' => 'A steady full-body split with moderate load, recovery, and consistency.',
                    'detail' => '3–4 sessions, moderate volume, balanced rest.',
                    'color' => '#38bdf8',
                ],
                [
                    'title' => 'Strength & Recovery',
                    'desc' => 'Focus on control, steady progress, and sustainable intensity.',
                    'detail' => 'Compound lifts with easy recovery days.',
                    'color' => '#f97316',
                ],
                [
                    'title' => 'Mobility Boost',
                    'desc' => 'Add joint care and active recovery into your weekly routine.',
                    'detail' => 'Movement prep, stretch, and light conditioning.',
                    'color' => '#10b981',
                ],
            ],
            'muscle_gain' => [
                [
                    'title' => 'Hypertrophy Split',
                    'desc' => 'Build muscle with targeted volume and progressive overload.',
                    'detail' => 'Chest/back, legs, shoulders/arms, core.',
                    'color' => '#ec4899',
                ],
                [
                    'title' => 'Push/Pull/Legs',
                    'desc' => 'Balance intensity across movement patterns for size gains.',
                    'detail' => 'Heavy compound lifts plus accessory work.',
                    'color' => '#f59e0b',
                ],
                [
                    'title' => 'Strength Focus',
                    'desc' => 'Increase strength with lower rep ranges and solid rest.',
                    'detail' => '3–5 sets of 4–8 reps on main lifts.',
                    'color' => '#2563eb',
                ],
            ],
            'fat_loss' => [
                [
                    'title' => 'Fat Loss Circuit',
                    'desc' => 'High-energy circuits that keep heart rate up and burn calories.',
                    'detail' => 'Easy transitions with bodyweight and dumbbell moves.',
                    'color' => '#ef4444',
                ],
                [
                    'title' => 'Full Body Conditioning',
                    'desc' => 'Short intense sessions with metabolic and strength work.',
                    'detail' => '3–4 workouts per week with active recovery.',
                    'color' => '#14b8a6',
                ],
                [
                    'title' => 'Interval Strength',
                    'desc' => 'Mix strength sets with short cardio bursts for fat loss.',
                    'detail' => 'Compound lifts paired with intervals.',
                    'color' => '#8b5cf6',
                ],
            ],
        ];

        $fitnessGoal = $user->onboarding?->fitness_goal ?? 'maintenance';
        $recommendedPrograms = $programGoals[$fitnessGoal] ?? $programGoals['maintenance'];

        return view('workout.index', compact(
            'selectedDate',
            'calendarMonth',
            'calendarDays',
            'monthWorkouts',
            'selectedWorkout',
            'exercises',
            'categories',
            'recommendedPrograms',
            'fitnessGoal'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exercise_id' => ['required', 'exists:exercises,id'],
            'set_reps' => ['required', 'array', 'min:1'],
            'set_reps.*' => ['required', 'string', 'max:50'],
            'set_weight' => ['nullable', 'array'],
            'set_weight.*' => ['nullable', 'numeric'],
            'selected_date' => ['nullable', 'date'],
            'plan_action' => ['required', 'in:plan,finish'],
        ]);

        $selectedDate = $data['selected_date'] ? Carbon::parse($data['selected_date'])->toDateString() : today()->toDateString();
        $exerciseModel = Exercise::findOrFail($data['exercise_id']);
        $setWeights = $data['set_weight'] ?? [];
        $sets = [];
        $totalReps = 0;
        $allNumericReps = true;

        foreach ($data['set_reps'] as $index => $reps) {
            $weight = $setWeights[$index] ?? null;
            if ($exerciseModel->equipment === 'Bodyweight') {
                $weight = 'Bodyweight';
            } else {
                $weight = $weight !== null && $weight !== '' ? (string) $weight : null;
            }

            $sets[] = [
                'reps' => $reps,
                'weight' => $weight,
            ];

            if (is_numeric($reps)) {
                $totalReps += (int) $reps;
            } else {
                $allNumericReps = false;
            }
        }

        $exercise = [
            'id' => $exerciseModel->id,
            'name' => $exerciseModel->name,
            'category' => $exerciseModel->category,
            'equipment' => $exerciseModel->equipment,
            'image_path' => $exerciseModel->image_path,
            'sets' => $sets,
            'logged_at' => now()->toDateTimeString(),
        ];

        $workout = $request->user()->workouts()->firstOrNew([
            'user_id' => $request->user()->id,
            'date' => $selectedDate,
        ]);

        $existing = is_array($workout->exercises)
            ? $workout->exercises
            : json_decode($workout->exercises ?? '[]', true);

        if (! is_array($existing)) {
            $existing = [];
        }

        $existing[] = $exercise;

        $totalSets = 0;
        $totalWeight = 0;
        foreach ($existing as $item) {
            foreach ($item['sets'] as $set) {
                $totalSets++;
                if (is_numeric($set['weight'])) {
                    $totalWeight += (float) $set['weight'];
                }
            }
        }

        $workout->user_id = $request->user()->id;
        $workout->exercises = $existing;
        $workout->total_sets = $totalSets;
        $workout->total_reps = $allNumericReps ? $totalReps : null;
        $workout->total_weight = $totalWeight ?: null;
        $workout->completed = $data['plan_action'] === 'finish' ? true : ($workout->exists ? $workout->completed : false);
        $workout->save();

        return redirect()->route('workout.index', ['date' => $selectedDate])->with('success', 'Workout updated successfully.');
    }

    public function toggle(Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403);
        }

        $workout->completed = ! $workout->completed;
        $workout->save();

        return redirect()->route('workout.index', ['date' => $workout->date->format('Y-m-d')])->with('success', 'Workout marked as ' . ($workout->completed ? 'finished' : 'planned') . '.');
    }
}
