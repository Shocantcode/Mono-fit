<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function show()
    {
        return view('onboarding');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'age' => 'required|integer|min:10|max:100',
            'gender' => 'required|in:male,female,other',
            'height' => 'required|numeric|min:100|max:250',
            'weight' => 'required|numeric|min:30|max:250',
            'body_fat' => 'nullable|numeric|min:1|max:60',
            'activity_level' => 'required|string',
            'fitness_goal' => 'required|in:fat_loss,muscle_gain,maintenance',
            'equipment' => 'required|array',
            'equipment.*' => 'in:home,dumbbell,full_gym',
        ]);

        // Calculate BMI, BMR, TDEE, Somatotype (placeholder logic)
        $height_m = $data['height'] / 100;
        $bmi = $data['weight'] / ($height_m * $height_m);
        $bmr = 10 * $data['weight'] + 6.25 * $data['height'] - 5 * $data['age'] + ($data['gender'] === 'male' ? 5 : -161);
        $activity_factors = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];
        $tdee = $bmr * ($activity_factors[$data['activity_level']] ?? 1.2);
        $somatotype = $bmi < 18.5 ? 'ectomorph' : ($bmi < 25 ? 'mesomorph' : 'endomorph');

        $user = $request->user();
        $user->onboarding()->updateOrCreate(
            ['user_id' => $user->id],
            [
                ...$data,
                'equipment' => json_encode($data['equipment']),
                'bmi' => $bmi,
                'bmr' => $bmr,
                'tdee' => $tdee,
                'somatotype' => $somatotype,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Onboarding complete!');
    }
}
