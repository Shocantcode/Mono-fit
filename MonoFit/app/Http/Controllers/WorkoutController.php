<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $workout = $user->workouts()->whereDate('date', today())->first();
        if ($workout) {
            $workout->exercises = is_array($workout->exercises)
                ? $workout->exercises
                : json_decode($workout->exercises ?? '[]', true) ?? [];
        }

        $exercises = Exercise::orderBy('category')->orderBy('name')->get();
        $categories = Exercise::select('category')->distinct()->pluck('category');

        return view('workout.index', compact('workout', 'exercises', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exercise_id' => ['required', 'exists:exercises,id'],
            'set_reps' => ['required', 'array', 'min:1'],
            'set_reps.*' => ['required', 'string', 'max:50'],
            'set_weight' => ['nullable', 'array'],
            'set_weight.*' => ['nullable', 'numeric'],
        ]);

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

        $workout = $request->user()->workouts()->firstOrNew(['date' => today()]);
        $existing = json_decode($workout->exercises ?? '[]', true);
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
        $workout->exercises = json_encode($existing);
        $workout->total_sets = $totalSets;
        $workout->total_reps = $allNumericReps ? $totalReps : null;
        $workout->total_weight = $totalWeight ?: null;
        $workout->completed = false;
        $workout->save();

        return redirect()->route('workout.index')->with('success', 'Workout logged successfully.');
    }
}
