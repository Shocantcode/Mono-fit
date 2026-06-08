<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $workout = $user->workouts()->whereDate('date', today())->first();

        return view('workout.index', compact('workout'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'exercise' => ['required', 'string', 'max:255'],
            'sets' => ['required', 'integer', 'min:1', 'max:20'],
            'reps' => ['required', 'string', 'max:50'],
            'weight' => ['nullable', 'string', 'max:50'],
        ]);

        $exercise = [
            'name' => $data['exercise'],
            'sets' => (int) $data['sets'],
            'reps' => $data['reps'],
            'weight' => isset($data['weight']) && $data['weight'] ? $data['weight'] : 'Bodyweight',
            'logged_at' => now()->toDateTimeString(),
        ];

        $workout = $request->user()->workouts()->firstOrNew(['date' => today()]);
        $existing = json_decode($workout->exercises ?? '[]', true);
        $existing[] = $exercise;

        $totalSets = 0;
        $totalWeight = 0;
        foreach ($existing as $item) {
            $totalSets += $item['sets'];
            if (is_numeric($item['weight'])) {
                $totalWeight += $item['sets'] * (float) $item['weight'];
            }
        }

        $workout->user_id = $request->user()->id;
        $workout->exercises = json_encode($existing);
        $workout->total_sets = $totalSets;
        $workout->total_reps = null;
        $workout->total_weight = $totalWeight ?: null;
        $workout->completed = false;
        $workout->save();

        return redirect()->route('workout.index')->with('success', 'Workout exercise saved.');
    }}
