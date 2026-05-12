<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Fetch today's nutrition
        $nutrition = $user->nutritions()->where('date', today())->first();
        // Fetch today's workout
        $workout = $user->workouts()->where('date', today())->first();
        // Fetch today's progress
        $progress = $user->progresses()->where('date', today())->first();

        return view('dashboard', [
            'calories' => $nutrition->total_calories ?? 0,
            'protein' => $nutrition->protein ?? 0,
            'carbs' => $nutrition->carbs ?? 0,
            'fat' => $nutrition->fat ?? 0,
            'water' => $nutrition->water_intake ?? 0,
            'workout' => $workout ? [
                'exercises' => json_decode($workout->exercises, true) ?? []
            ] : null,
            'streak' => $progress->streak ?? 0,
        ]);
    }
}
