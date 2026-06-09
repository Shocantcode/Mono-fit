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

        $targetCalories = $onboarding?->recommended_calories ?? ($onboarding?->tdee ? round($onboarding->tdee) : 2000);
        $goalLabel = null;
        $weight = $onboarding?->weight ?? 0;
        $fitnessGoal = $onboarding?->fitness_goal ?? 'maintenance';

        if ($onboarding?->fitness_goal) {
            $goalLabel = match ($onboarding->fitness_goal) {
                'fat_loss' => 'Weight Loss',
                'maintenance' => 'Maintain Weight',
                'muscle_gain' => 'Muscle Gain',
                default => 'Daily Goal',
            };
        }

        $proteinMultiplier = match ($fitnessGoal) {
            'fat_loss' => 1.8,
            'muscle_gain' => 2.0,
            default => 1.4,
        };

        $proteinGoal = round($proteinMultiplier * $weight, 1);
        $fatGoal = round(0.9 * $weight, 1);
        $waterGoalMl = round(35 * $weight);
        $waterGoalL = round($waterGoalMl / 1000, 2);

        $caloriesFromProtein = $proteinGoal * 4;
        $caloriesFromFat = $fatGoal * 9;
        $carbsGoal = max(0, round(($targetCalories - ($caloriesFromProtein + $caloriesFromFat)) / 4, 1));

        return view('nutrition.index', compact(
            'calories',
            'protein',
            'carbs',
            'fat',
            'water',
            'targetCalories',
            'goalLabel',
            'proteinGoal',
            'fatGoal',
            'carbsGoal',
            'waterGoalMl',
            'waterGoalL'
        ));
    }
}
