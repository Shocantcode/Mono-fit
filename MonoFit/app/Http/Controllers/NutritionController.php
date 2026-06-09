<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $weight = $onboarding?->weight ?? 60;
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

        $recipes = Recipe::whereIn('goal', [$fitnessGoal, 'all'])->orderBy('goal')->get();
        $meals = $nutrition?->meals ?? [];

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
            'waterGoalL',
            'recipes',
            'meals',
            'fitnessGoal'
        ));
    }

    public function storeMeal(Request $request)
    {
        $customFoods = [
            'chicken_breast' => ['label' => 'Dada Ayam', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
            'chicken_thigh' => ['label' => 'Paha Ayam', 'calories' => 209, 'protein' => 25, 'carbs' => 0, 'fat' => 10],
            'beef_sirloin' => ['label' => 'Daging Sapi', 'calories' => 217, 'protein' => 27, 'carbs' => 0, 'fat' => 11],
            'salmon' => ['label' => 'Salmon', 'calories' => 208, 'protein' => 20, 'carbs' => 0, 'fat' => 13],
            'greek_yogurt' => ['label' => 'Greek Yogurt', 'calories' => 59, 'protein' => 10, 'carbs' => 4, 'fat' => 0.4],
        ];

        $rules = [
            'meal_source' => ['required', Rule::in(['recipe', 'custom'])],
            'meal_type' => ['required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
        ];

        if ($request->input('meal_source') === 'recipe') {
            $rules['recipe_id'] = ['required', 'exists:recipes,id'];
        } else {
            $rules['custom_type'] = ['required', Rule::in(['fixed', 'other'])];
            $rules['custom_grams'] = ['required', 'integer', 'min:10'];

            if ($request->input('custom_type') === 'fixed') {
                $rules['custom_choice'] = ['required', Rule::in(array_keys($customFoods))];
            } else {
                $rules['custom_name'] = ['required', 'string', 'max:120'];
                $rules['custom_calories'] = ['required', 'numeric', 'min:1'];
                $rules['custom_protein'] = ['required', 'numeric', 'min:0'];
                $rules['custom_carbs'] = ['required', 'numeric', 'min:0'];
                $rules['custom_fat'] = ['required', 'numeric', 'min:0'];
            }
        }

        $request->validate($rules);

        $user = Auth::user();
        $nutrition = $user->nutritions()->firstOrNew(['date' => today()]);
        $meals = $nutrition->meals ?? [];

        if ($request->input('meal_source') === 'recipe') {
            $recipe = Recipe::findOrFail($request->input('recipe_id'));
            $meal = [
                'source' => 'recipe',
                'recipe_id' => $recipe->id,
                'name' => $recipe->name,
                'goal' => $recipe->goal,
                'calories' => $recipe->calories,
                'protein' => $recipe->protein,
                'carbs' => $recipe->carbs,
                'fat' => $recipe->fat,
                'details' => 'App recipe',
                'meal_type' => $request->input('meal_type'),
            ];
        } else {
            $grams = (int) $request->input('custom_grams');
            if ($request->input('custom_type') === 'fixed') {
                $food = $customFoods[$request->input('custom_choice')];
                $factor = $grams / 100;
                $meal = [
                    'source' => 'custom',
                    'custom_type' => 'fixed',
                    'name' => $food['label'],
                    'grams' => $grams,
                    'calories' => round($food['calories'] * $factor, 1),
                    'protein' => round($food['protein'] * $factor, 1),
                    'carbs' => round($food['carbs'] * $factor, 1),
                    'fat' => round($food['fat'] * $factor, 1),
                    'meal_type' => $request->input('meal_type'),
                ];
            } else {
                $meal = [
                    'source' => 'custom',
                    'custom_type' => 'other',
                    'name' => $request->input('custom_name'),
                    'grams' => $grams,
                    'calories' => round($request->input('custom_calories'), 1),
                    'protein' => round($request->input('custom_protein'), 1),
                    'carbs' => round($request->input('custom_carbs'), 1),
                    'fat' => round($request->input('custom_fat'), 1),
                    'meal_type' => $request->input('meal_type'),
                ];
            }
        }

        $meals[] = $meal;
        $nutrition->meals = $meals;
        $nutrition->total_calories = ($nutrition->total_calories ?? 0) + $meal['calories'];
        $nutrition->protein = ($nutrition->protein ?? 0) + $meal['protein'];
        $nutrition->carbs = ($nutrition->carbs ?? 0) + $meal['carbs'];
        $nutrition->fat = ($nutrition->fat ?? 0) + $meal['fat'];
        $nutrition->water_intake = $nutrition->water_intake ?? 0;
        $nutrition->save();

        return redirect()->route('nutrition.index')->with('success', 'Meal has been logged successfully.');
    }

    public function storeWater(Request $request)
    {
        $waterMl = $request->input('water_ml') ?? $request->input('custom_water_ml');

        $request->merge(['water_ml' => $waterMl]);
        $request->validate([
            'water_ml' => ['required', 'integer', 'min:1'],
        ]);

        $user = Auth::user();
        $nutrition = $user->nutritions()->firstOrNew(['date' => today()]);
        $nutrition->water_intake = ($nutrition->water_intake ?? 0) + ($waterMl / 1000);
        $nutrition->total_calories = $nutrition->total_calories ?? 0;
        $nutrition->protein = $nutrition->protein ?? 0;
        $nutrition->carbs = $nutrition->carbs ?? 0;
        $nutrition->fat = $nutrition->fat ?? 0;
        $nutrition->meals = $nutrition->meals ?? [];
        $nutrition->save();

        return redirect()->route('nutrition.index')->with('success', 'Water intake updated.');
    }
}
