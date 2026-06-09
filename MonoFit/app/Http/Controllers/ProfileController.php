<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $allWorkouts = $user->workouts()->orderBy('date', 'desc')->get();
        $recentWorkouts = $allWorkouts->take(5);

        $personalRecords = [
            'workouts_completed' => $allWorkouts->count(),
            'best_workout_weight' => $allWorkouts->max('total_weight'),
            'best_workout_sets' => $allWorkouts->max('total_sets'),
            'heaviest_lift' => [
                'name' => null,
                'weight' => null,
            ],
        ];

        foreach ($allWorkouts as $workout) {
            $workoutExercises = is_array($workout->exercises)
                ? $workout->exercises
                : json_decode($workout->exercises ?? '[]', true) ?? [];

            foreach ($workoutExercises as $exercise) {
                if (isset($exercise['weight']) && is_numeric($exercise['weight']) && ($personalRecords['heaviest_lift']['weight'] === null || $exercise['weight'] > $personalRecords['heaviest_lift']['weight'])) {
                    $personalRecords['heaviest_lift'] = [
                        'name' => $exercise['name'] ?? 'Exercise',
                        'weight' => (float) $exercise['weight'],
                    ];
                }
            }
        }

        return view('profile.edit', [
            'user' => $user,
            'onboarding' => $user->onboarding,
            'recentWorkouts' => $recentWorkouts,
            'personalRecords' => $personalRecords,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->fill(Arr::only($validated, ['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $equipment = $user->onboarding?->equipment ?? json_encode(['home']);
        $equipment = is_string($equipment) ? $equipment : json_encode($equipment);

        $height_m = $validated['height'] / 100;
        $bmi = $validated['weight'] / ($height_m * $height_m);
        $bmr = 10 * $validated['weight'] + 6.25 * $validated['height'] - 5 * $validated['age'] + ($validated['gender'] === 'male' ? 5 : -161);
        $activity_factors = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];
        $tdee = $bmr * ($activity_factors[$validated['activity_level']] ?? 1.2);
        $somatotype = $bmi < 18.5 ? 'ectomorph' : ($bmi < 25 ? 'mesomorph' : 'endomorph');

        $user->onboarding()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'height' => $validated['height'],
                'weight' => $validated['weight'],
                'body_fat' => $validated['body_fat'] ?? $user->onboarding?->body_fat,
                'activity_level' => $validated['activity_level'],
                'fitness_goal' => $validated['fitness_goal'],
                'equipment' => $equipment,
                'bmi' => $bmi,
                'bmr' => $bmr,
                'tdee' => $tdee,
                'somatotype' => $somatotype,
            ]
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
