<?php

namespace Database\Seeders;

use App\Models\Nutrition;
use App\Models\Onboarding;
use App\Models\Progress;
use App\Models\User;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the admin account with complete dummy data and unlocked achievements.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin123@test.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create Onboarding Data
        Onboarding::create([
            'user_id' => $admin->id,
            'age' => 28,
            'gender' => 'male',
            'height' => 175, // cm
            'weight' => 78, // kg
            'body_fat' => 15.5,
            'activity_level' => 'moderate',
            'fitness_goal' => 'muscle_gain',
            'equipment' => ['dumbbells', 'barbell', 'cable_machine', 'rowing_machine'],
            'bmi' => 25.5,
            'bmr' => 1750,
            'tdee' => 2450,
            'somatotype' => 'mesomorph',
        ]);

        // Create 32 Workouts (to unlock "Iron Will" & "Cardio King")
        $exerciseTemplates = [
            [
                'name' => 'Bench Press',
                'category' => 'Chest',
                'equipment' => 'Barbell',
                'image_path' => 'public/images/exercises/bench-press.jpg',
                'sets' => [
                    ['weight' => 80, 'reps' => 8],
                    ['weight' => 80, 'reps' => 8],
                    ['weight' => 75, 'reps' => 10],
                ]
            ],
            [
                'name' => 'Deadlift',
                'category' => 'Back',
                'equipment' => 'Barbell',
                'image_path' => 'public/images/exercises/deadlift.jpg',
                'sets' => [
                    ['weight' => 120, 'reps' => 5],
                    ['weight' => 120, 'reps' => 5],
                    ['weight' => 115, 'reps' => 6],
                ]
            ],
            [
                'name' => 'Squat',
                'category' => 'Legs',
                'equipment' => 'Barbell',
                'image_path' => 'public/images/exercises/squat.jpg',
                'sets' => [
                    ['weight' => 100, 'reps' => 8],
                    ['weight' => 100, 'reps' => 8],
                    ['weight' => 95, 'reps' => 10],
                ]
            ],
            [
                'name' => 'Pull-ups',
                'category' => 'Back',
                'equipment' => 'Bodyweight',
                'image_path' => 'public/images/exercises/pullups.jpg',
                'sets' => [
                    ['weight' => 0, 'reps' => 12],
                    ['weight' => 0, 'reps' => 10],
                    ['weight' => 0, 'reps' => 9],
                ]
            ],
            [
                'name' => 'Dumbbell Rows',
                'category' => 'Back',
                'equipment' => 'Dumbbells',
                'image_path' => 'public/images/exercises/dumbbell-rows.jpg',
                'sets' => [
                    ['weight' => 35, 'reps' => 10],
                    ['weight' => 35, 'reps' => 10],
                ]
            ],
            [
                'name' => 'Overhead Press',
                'category' => 'Shoulders',
                'equipment' => 'Barbell',
                'image_path' => 'public/images/exercises/overhead-press.jpg',
                'sets' => [
                    ['weight' => 55, 'reps' => 8],
                    ['weight' => 55, 'reps' => 8],
                ]
            ],
        ];

        $today = Carbon::now();
        $workoutDates = [];

        // Create 32 workouts spread across past 60 days
        for ($i = 0; $i < 32; $i++) {
            $date = $today->copy()->subDays(60 - (int)($i * 60 / 32))->startOfDay();
            
            // Ensure we have variety in dates
            if (in_array($date->toDateString(), $workoutDates)) {
                $date = $date->copy()->addDays(1);
            }
            $workoutDates[] = $date->toDateString();

            $exercise = $exerciseTemplates[$i % count($exerciseTemplates)];

            Workout::create([
                'user_id' => $admin->id,
                'date' => $date,
                'exercises' => [
                    array_merge($exercise, ['completed' => true])
                ],
                'total_sets' => count($exercise['sets']),
                'total_reps' => array_sum(array_map(fn($s) => $s['reps'], $exercise['sets'])),
                'total_weight' => array_sum(array_map(fn($s) => $s['weight'], $exercise['sets'])),
                'completed' => true,
            ]);
        }

        // Create Progress entries with streak and weight tracking
        $progressWeight = 78;
        $streakCount = 0;

        for ($i = 29; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->startOfDay();
            $hasWorkout = in_array($date->toDateString(), $workoutDates);

            if ($hasWorkout) {
                $streakCount++;
            } else {
                // Reset streak if no workout on certain days
                if ($streakCount > 0 && rand(0, 2) === 0) {
                    $streakCount = 0;
                }
            }

            // Gradually decrease weight (for "muscle_gain" goal, should increase, but for variety)
            $progressWeight = $progressWeight - (rand(0, 10) / 100);

            Progress::create([
                'user_id' => $admin->id,
                'date' => $date,
                'weight' => round($progressWeight, 2),
                'calories' => rand(2000, 2800),
                'workout_completed' => $hasWorkout,
                'streak' => $streakCount >= 7 ? $streakCount : 0, // Set to 0 if < 7, else actual count
            ]);
        }

        // Set latest progress with high streak for "On Fire" badge
        Progress::where('user_id', $admin->id)->latest('date')->first()?->update([
            'streak' => 10, // Unlock "On Fire" (>= 7)
        ]);

        // Create 14+ Nutrition entries to unlock "Clean Eater" badge
        $waterGoalL = 2.73; // Based on BMR calculation: 35 * 78 / 1000

        for ($i = 13; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->startOfDay();

            Nutrition::create([
                'user_id' => $admin->id,
                'date' => $date,
                'meals' => [
                    ['name' => 'Breakfast', 'calories' => 450, 'protein' => 35, 'carbs' => 50, 'fat' => 15, 'meal_type' => 'breakfast', 'source' => 'custom'],
                    ['name' => 'Lunch', 'calories' => 650, 'protein' => 50, 'carbs' => 70, 'fat' => 20, 'meal_type' => 'lunch', 'source' => 'custom'],
                    ['name' => 'Dinner', 'calories' => 700, 'protein' => 55, 'carbs' => 60, 'fat' => 25, 'meal_type' => 'dinner', 'source' => 'custom'],
                    ['name' => 'Snack', 'calories' => 200, 'protein' => 15, 'carbs' => 30, 'fat' => 5, 'meal_type' => 'snack', 'source' => 'custom'],
                ],
                'total_calories' => 2000,
                'protein' => 155,
                'carbs' => 210,
                'fat' => 65,
                'water_intake' => round($waterGoalL + (rand(0, 5) / 10), 2),
            ]);
        }

        // Add 4 more nutrition entries to ensure past 7 days also meet water goal for "Hydrated"
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->startOfDay();

            // Check if already exists
            if (!Nutrition::where('user_id', $admin->id)->whereDate('date', $date)->exists()) {
                Nutrition::create([
                    'user_id' => $admin->id,
                    'date' => $date,
                    'meals' => [
                        ['name' => 'Breakfast', 'calories' => 450, 'protein' => 35, 'carbs' => 50, 'fat' => 15, 'meal_type' => 'breakfast', 'source' => 'custom'],
                        ['name' => 'Lunch', 'calories' => 650, 'protein' => 50, 'carbs' => 70, 'fat' => 20, 'meal_type' => 'lunch', 'source' => 'custom'],
                        ['name' => 'Dinner', 'calories' => 700, 'protein' => 55, 'carbs' => 60, 'fat' => 25, 'meal_type' => 'dinner', 'source' => 'custom'],
                    ],
                    'total_calories' => 1800,
                    'protein' => 140,
                    'carbs' => 180,
                    'fat' => 60,
                    'water_intake' => round($waterGoalL + (rand(0, 5) / 10), 2),
                ]);
            }
        }

        // Create 6 workouts for this week to unlock "Power Week" badge
        $weekStart = $today->copy()->startOfWeek();

        for ($dayOffset = 0; $dayOffset < 6; $dayOffset++) {
            $workoutDate = $weekStart->copy()->addDays($dayOffset);

            // Skip if already exists
            if (!Workout::where('user_id', $admin->id)->whereDate('date', $workoutDate)->exists()) {
                $exercise = $exerciseTemplates[$dayOffset % count($exerciseTemplates)];

                Workout::create([
                    'user_id' => $admin->id,
                    'date' => $workoutDate,
                    'exercises' => [
                        array_merge($exercise, ['completed' => true])
                    ],
                    'total_sets' => count($exercise['sets']),
                    'total_reps' => array_sum(array_map(fn($s) => $s['reps'], $exercise['sets'])),
                    'total_weight' => array_sum(array_map(fn($s) => $s['weight'], $exercise['sets'])),
                    'completed' => true,
                ]);
            }
        }

        $this->command->info('Admin account created successfully!');
        $this->command->info('Email: admin123@test.com');
        $this->command->info('Password: admin123');
        $this->command->info('');
        $this->command->info('Unlocked Achievements:');
        $this->command->info('✓ 🔥 On Fire (7+ day streak)');
        $this->command->info('✓ 💪 Iron Will (30+ workouts)');
        $this->command->info('✓ 🥗 Clean Eater (14+ days nutrition logs)');
        $this->command->info('✓ 💧 Hydrated (7+ days meeting water goal)');
        $this->command->info('✓ 🏃 Cardio King (10+ completed workouts)');
        $this->command->info('✓ ⚡ Power Week (6+ workouts this week)');
    }
}
