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

        $calories = $nutrition?->total_calories ?? 0;
        $protein  = $nutrition?->protein ?? 0;
        $carbs    = $nutrition?->carbs ?? 0;
        $fat      = $nutrition?->fat ?? 0;
        $water    = $nutrition?->water_intake ?? 0;

        return view('nutrition.index', compact('calories', 'protein', 'carbs', 'fat', 'water'));
    }
}
