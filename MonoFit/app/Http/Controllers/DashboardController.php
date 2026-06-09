<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $onboarding = $user->onboarding;

        if (! $onboarding) {
            return redirect()->route('onboarding.show');
        }

        // Fetch today's nutrition
        $nutrition = $user->nutritions()->where('date', today())->first();
        // Fetch today's workout
        $workout = $user->workouts()->where('date', today())->first();
        // Fetch today's progress
        $progress = $user->progresses()->where('date', today())->first();

        $bmi = $onboarding->bmi ? number_format($onboarding->bmi, 1) : null;
        $bmiLabel = null;
        if ($onboarding->bmi) {
            $bmiLabel = $onboarding->bmi < 18.5 ? 'Underweight' : ($onboarding->bmi < 25 ? 'Normal' : ($onboarding->bmi < 30 ? 'Overweight' : 'Obese'));
        }

        return view('dashboard', [
            'calories' => $nutrition->total_calories ?? 0,
            'protein' => $nutrition->protein ?? 0,
            'carbs' => $nutrition->carbs ?? 0,
            'fat' => $nutrition->fat ?? 0,
            'water' => $nutrition->water_intake ?? 0,
            'workout' => $workout ? [
                'exercises' => is_array($workout->exercises)
                    ? $workout->exercises
                    : (json_decode($workout->exercises ?? '[]', true) ?? [])
            ] : null,
            'streak' => $progress->streak ?? 0,
            'bmi' => $bmi,
            'bmiLabel' => $bmiLabel,
            'onboarding' => $onboarding,
        ]);
    }
}
