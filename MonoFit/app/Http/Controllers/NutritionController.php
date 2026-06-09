<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nutrition = $user->nutritions()->whereDate('date', today())->first();
        $onboarding = $user->onboarding;

        $calories = $nutrition?->total_calories ?? 0;
        $protein  = $nutrition?->protein ?? 0;
        $carbs    = $nutrition?->carbs ?? 0;
        $fat      = $nutrition?->fat ?? 0;
        $water    = $nutrition?->water_intake ?? 0;

        $targetCalories = $onboarding?->recommended_calories ?? 2000;
        $goalLabel = null;

        if ($onboarding?->fitness_goal) {
            $goalLabel = match ($onboarding->fitness_goal) {
                'fat_loss' => 'Weight Loss',
                'maintenance' => 'Maintain Weight',
                'muscle_gain' => 'Muscle Gain',
                default => 'Daily Goal',
            };
        }

        return view('nutrition.index', compact('calories', 'protein', 'carbs', 'fat', 'water', 'targetCalories', 'goalLabel'));
    }
}
