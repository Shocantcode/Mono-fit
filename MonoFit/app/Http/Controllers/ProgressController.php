<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $onboarding = $user->onboarding;

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $completedWorkouts = $user->workouts()
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->where('completed', true)
            ->get();

        $weeklyActivity = collect(['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0, 'Fri' => 0, 'Sat' => 0, 'Sun' => 0]);

        foreach ($completedWorkouts as $workout) {
            $dayKey = $workout->date->format('D');
            if ($weeklyActivity->has($dayKey)) {
                $weeklyActivity[$dayKey]++;
            }
        }

        $weekNutrition = $user->nutritions()
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->get();

        $avgKcal = $weekNutrition->avg('total_calories') ?: 0;
        $avgWater = $weekNutrition->avg('water_intake') ?: 0;

        $latestProgress = $user->progresses()->orderByDesc('date')->first();
        $currentWeight = $latestProgress?->weight ?? $onboarding?->weight ?? 0;

        $fitnessGoal = $onboarding?->fitness_goal ?? 'maintenance';
        $targetWeight = round(match ($fitnessGoal) {
            'fat_loss' => max(0, $currentWeight - 5),
            'muscle_gain' => $currentWeight + 3,
            default => $currentWeight,
        }, 1);

        $weight = $onboarding?->weight ?? $currentWeight;
        $proteinMultiplier = match ($fitnessGoal) {
            'fat_loss' => 1.8,
            'muscle_gain' => 2.0,
            default => 1.4,
        };

        $proteinGoal = round($proteinMultiplier * $weight, 1);
        $waterGoalMl = round(35 * $weight);
        $waterGoalL = round($waterGoalMl / 1000, 2);

        $todayNutrition = $user->nutritions()->whereDate('date', today())->first();
        $todayWater = $todayNutrition?->water_intake ?? 0;
        $todayProtein = $todayNutrition?->protein ?? 0;

        $workoutsThisWeek = $completedWorkouts->count();
        $totalWorkouts = $user->workouts()->where('completed', true)->count();
        $streak = optional($latestProgress)->streak ?? 0;

        $last7Nutrition = $user->nutritions()
            ->whereBetween('date', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->get();

        $hydratedDays = $last7Nutrition->filter(fn ($entry) => $entry->water_intake >= $waterGoalL)->count();

        $last14Nutrition = $user->nutritions()
            ->whereBetween('date', [Carbon::now()->subDays(13)->startOfDay(), Carbon::now()->endOfDay()])
            ->get();

        $cleanEaterUnlocked = $last14Nutrition->count() >= 14;

        $goals = [
            [
                'label' => 'Weight Goal',
                'current' => $currentWeight,
                'target' => $targetWeight,
                'unit' => 'kg',
                'color' => '#ff4500',
                'icon' => '⚖️',
            ],
            [
                'label' => 'Weekly Workouts',
                'current' => $workoutsThisWeek,
                'target' => 6,
                'unit' => 'sessions',
                'color' => '#10b981',
                'icon' => '🏋️',
            ],
            [
                'label' => 'Daily Water',
                'current' => $todayWater,
                'target' => $waterGoalL,
                'unit' => 'L',
                'color' => '#06b6d4',
                'icon' => '💧',
            ],
            [
                'label' => 'Protein Goal',
                'current' => $todayProtein,
                'target' => $proteinGoal,
                'unit' => 'g/day',
                'color' => '#3b82f6',
                'icon' => '🥩',
            ],
        ];

        $badges = [
            ['emoji' => '🔥', 'name' => 'On Fire', 'desc' => '7 day streak', 'unlocked' => $streak >= 7],
            ['emoji' => '💪', 'name' => 'Iron Will', 'desc' => '30 workouts logged', 'unlocked' => $totalWorkouts >= 30],
            ['emoji' => '🥗', 'name' => 'Clean Eater', 'desc' => '14 days of nutrition logs', 'unlocked' => $cleanEaterUnlocked],
            ['emoji' => '💧', 'name' => 'Hydrated', 'desc' => '7 days meeting water goal', 'unlocked' => $hydratedDays >= 7],
            ['emoji' => '🏃', 'name' => 'Cardio King', 'desc' => '10 completed workouts', 'unlocked' => $totalWorkouts >= 10],
            ['emoji' => '⚡', 'name' => 'Power Week', 'desc' => '6 workouts in one week', 'unlocked' => $workoutsThisWeek >= 6],
        ];

        return view('progress.index', compact(
            'streak',
            'weeklyActivity',
            'workoutsThisWeek',
            'avgKcal',
            'avgWater',
            'goals',
            'badges'
        ));
    }
}
