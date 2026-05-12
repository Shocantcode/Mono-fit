@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800 text-white">
    <div class="w-full max-w-md p-8 rounded-2xl shadow-xl bg-white/10 backdrop-blur-md border border-white/20">
        <h1 class="text-3xl font-bold mb-6 text-center">Welcome to MonoFit</h1>
        <form method="POST" action="{{ route('onboarding.store') }}" class="space-y-4">
            @csrf
            <!-- Step 1: Age -->
            <div>
                <label for="age" class="block text-sm font-medium">Age</label>
                <input type="number" name="age" id="age" min="10" max="100" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <!-- Step 2: Gender -->
            <div>
                <label for="gender" class="block text-sm font-medium">Gender</label>
                <select name="gender" id="gender" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <!-- Step 3: Height -->
            <div>
                <label for="height" class="block text-sm font-medium">Height (cm)</label>
                <input type="number" name="height" id="height" min="100" max="250" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2" />
            </div>
            <!-- Step 4: Weight -->
            <div>
                <label for="weight" class="block text-sm font-medium">Weight (kg)</label>
                <input type="number" name="weight" id="weight" min="30" max="250" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2" />
            </div>
            <!-- Step 5: Body Fat -->
            <div>
                <label for="body_fat" class="block text-sm font-medium">Body Fat (%)</label>
                <input type="number" name="body_fat" id="body_fat" min="1" max="60" step="0.1" class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2" />
            </div>
            <!-- Step 6: Activity Level -->
            <div>
                <label for="activity_level" class="block text-sm font-medium">Activity Level</label>
                <select name="activity_level" id="activity_level" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2">
                    <option value="sedentary">Sedentary</option>
                    <option value="light">Light</option>
                    <option value="moderate">Moderate</option>
                    <option value="active">Active</option>
                    <option value="very_active">Very Active</option>
                </select>
            </div>
            <!-- Step 7: Fitness Goal -->
            <div>
                <label for="fitness_goal" class="block text-sm font-medium">Fitness Goal</label>
                <select name="fitness_goal" id="fitness_goal" required class="mt-1 w-full rounded-lg bg-gray-900/60 border border-gray-700 px-4 py-2">
                    <option value="fat_loss">Fat Loss</option>
                    <option value="muscle_gain">Muscle Gain</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <!-- Step 8: Equipment -->
            <div>
                <label class="block text-sm font-medium">Available Equipment</label>
                <div class="flex flex-wrap gap-2 mt-1">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="equipment[]" value="home" class="form-checkbox text-blue-500" />
                        <span class="ml-2">Home</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="equipment[]" value="dumbbell" class="form-checkbox text-blue-500" />
                        <span class="ml-2">Dumbbell</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="equipment[]" value="full_gym" class="form-checkbox text-blue-500" />
                        <span class="ml-2">Full Gym</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 transition font-semibold text-lg shadow-lg mt-6">Continue</button>
        </form>
    </div>
</div>
@endsection
