<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $exercises = [
            ['name' => 'Bench Press', 'category' => 'Chest', 'muscle' => 'Pectoralis Major', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/BenchPress.gif', 'description' => 'Lie on a bench and press the barbell upward. Classic compound chest exercise.'],
            ['name' => 'Incline Dumbbell Press', 'category' => 'Chest', 'muscle' => 'Upper Chest', 'difficulty' => 'Intermediate', 'equipment' => 'Dumbbells', 'image_path' => 'images/exercises/Incline-Dumbbell-Press.gif', 'description' => 'Press dumbbells on an incline bench to target upper pecs.'],
            ['name' => 'Push-Up', 'category' => 'Chest', 'muscle' => 'Pectoralis Major', 'difficulty' => 'Beginner', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Push-Up.gif', 'description' => 'Classic bodyweight chest exercise. Great for strength and endurance.'],
            ['name' => 'Cable Crossover', 'category' => 'Chest', 'muscle' => 'Pectoralis Major', 'difficulty' => 'Intermediate', 'equipment' => 'Cable Machine', 'image_path' => 'images/exercises/Cable-Crossover.gif', 'description' => 'Isolate chest using cables with a wide arc movement.'],
            ['name' => 'Arnold Press', 'category' => 'Shoulders', 'muscle' => 'Deltoids', 'difficulty' => 'Intermediate', 'equipment' => 'Dumbbells', 'image_path' => 'images/exercises/Arnold Press.gif', 'description' => 'Rotate dumbbells while pressing overhead to hit the shoulders from all angles.'],
            ['name' => 'Overhead Press', 'category' => 'Shoulders', 'muscle' => 'Deltoids', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Overhead Press.gif', 'description' => 'Press the bar overhead to build shoulder strength and stability.'],
            ['name' => 'Lateral Raise', 'category' => 'Shoulders', 'muscle' => 'Lateral Deltoid', 'difficulty' => 'Beginner', 'equipment' => 'Dumbbells', 'image_path' => 'images/exercises/Lateral-Raise.gif', 'description' => 'Raise dumbbells out to the sides to isolate shoulder width.'],
            ['name' => 'Barbell Curl', 'category' => 'Arms', 'muscle' => 'Biceps', 'difficulty' => 'Beginner', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Barbell Curl.gif', 'description' => 'Curl the barbell to develop biceps size and strength.'],
            ['name' => 'Hammer Curl', 'category' => 'Arms', 'muscle' => 'Brachialis', 'difficulty' => 'Beginner', 'equipment' => 'Dumbbells', 'image_path' => 'images/exercises/Hammer Curl.gif', 'description' => 'Curl with a neutral grip to target the brachialis and forearms.'],
            ['name' => 'Skull Crusher', 'category' => 'Arms', 'muscle' => 'Triceps', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Skull-Crusher.gif', 'description' => 'Lower the bar behind the head to isolate the triceps.'],
            ['name' => 'Tricep Dips', 'category' => 'Arms', 'muscle' => 'Triceps', 'difficulty' => 'Beginner', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Tricep Dips.gif', 'description' => 'Use bodyweight to train the triceps and chest together.'],
            ['name' => 'Barbell Row', 'category' => 'Back', 'muscle' => 'Lats, Rhomboids', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/BarbelRow.gif', 'description' => 'Row the barbell toward your torso to build thickness in the upper back.'],
            ['name' => 'Pull-Up', 'category' => 'Back', 'muscle' => 'Lats', 'difficulty' => 'Intermediate', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/PULL_UP.gif', 'description' => 'Pull your body up from a bar to target the lats and upper back.'],
            ['name' => 'Lat Pulldown', 'category' => 'Back', 'muscle' => 'Lats', 'difficulty' => 'Beginner', 'equipment' => 'Cable Machine', 'image_path' => 'images/exercises/Lat Pulldown.gif', 'description' => 'Pull the bar to your chest to strengthen your lats and back width.'],
            ['name' => 'Deadlift', 'category' => 'Back', 'muscle' => 'Posterior Chain', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Barbell-Deadlift.gif', 'description' => 'Lift the bar from the ground to build back, glutes, and hamstrings.'],
            ['name' => 'Romanian Deadlift', 'category' => 'Legs', 'muscle' => 'Hamstrings', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Romanian.gif', 'description' => 'Hinge at the hips to train hamstrings and glute strength.'],
            ['name' => 'Back Squat', 'category' => 'Legs', 'muscle' => 'Quadriceps', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/BackSquad.gif', 'description' => 'Squat the barbell on your upper back to build leg power and size.'],
            ['name' => 'Leg Press', 'category' => 'Legs', 'muscle' => 'Quadriceps', 'difficulty' => 'Beginner', 'equipment' => 'Machine', 'image_path' => 'images/exercises/Leg Press.gif', 'description' => 'Push through your heels on the leg press machine for quad development.'],
            ['name' => 'Hip Thrust', 'category' => 'Glutes', 'muscle' => 'Glutes', 'difficulty' => 'Intermediate', 'equipment' => 'Barbell', 'image_path' => 'images/exercises/Hip Thrust.gif', 'description' => 'Drive your hips upward to activate the glutes and hamstrings.'],
            ['name' => 'Glute Kickbacks', 'category' => 'Glutes', 'muscle' => 'Glutes', 'difficulty' => 'Beginner', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Glute Kickbacks.gif', 'description' => 'Kick your leg back to isolate the glutes and improve hip strength.'],
            ['name' => 'Walking Lunges', 'category' => 'Legs', 'muscle' => 'Quadriceps', 'difficulty' => 'Beginner', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Walking Lunges.gif', 'description' => 'Step forward into lunges to train legs, glutes, and balance.'],
            ['name' => 'Sumo Squat', 'category' => 'Legs', 'muscle' => 'Inner Thighs', 'difficulty' => 'Intermediate', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Sumo Squat.gif', 'description' => 'Wide-stance squat to emphasize inner thighs and glutes.'],
            ['name' => 'Plank', 'category' => 'Core', 'muscle' => 'Abdominals', 'difficulty' => 'Beginner', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Plank.jpg', 'description' => 'Hold a straight-body plank to build core stability.'],
            ['name' => 'Hanging Leg Raise', 'category' => 'Core', 'muscle' => 'Lower Abs', 'difficulty' => 'Intermediate', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Hanging Leg Raise.gif', 'description' => 'Raise your legs while hanging to train lower abdominal control.'],
            ['name' => 'Cable Crunch', 'category' => 'Core', 'muscle' => 'Abs', 'difficulty' => 'Beginner', 'equipment' => 'Cable Machine', 'image_path' => 'images/exercises/Cable Crunch.gif', 'description' => 'Use the cable machine to crunch down with resistance and carve the abs.'],
            ['name' => 'Burpees', 'category' => 'Cardio', 'muscle' => 'Full Body', 'difficulty' => 'Advanced', 'equipment' => 'Bodyweight', 'image_path' => 'images/exercises/Jack-Burpees.gif', 'description' => 'Explosive bodyweight exercise combining squat, plank, and jump.'],
            ['name' => 'Jump Rope', 'category' => 'Cardio', 'muscle' => 'Full Body', 'difficulty' => 'Beginner', 'equipment' => 'Jump Rope', 'image_path' => 'images/exercises/Jump Rope.gif', 'description' => 'A quick cardio session perfect for conditioning and coordination.'],
            ['name' => 'Treadmill Run', 'category' => 'Cardio', 'muscle' => 'Full Body', 'difficulty' => 'Beginner', 'equipment' => 'Machine', 'image_path' => 'images/exercises/Treadmill Run.gif', 'description' => 'Steady-state treadmill run for endurance and calorie burn.'],
            ['name' => 'Rowing Machine', 'category' => 'Cardio', 'muscle' => 'Back, Legs', 'difficulty' => 'Beginner', 'equipment' => 'Machine', 'image_path' => 'images/exercises/rowing machine.gif', 'description' => 'Rowing machine workout for full-body conditioning and back strength.'],
        ];

        Exercise::truncate();
        Exercise::insert($exercises);
    }
}
