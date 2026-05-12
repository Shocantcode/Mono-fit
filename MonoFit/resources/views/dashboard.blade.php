@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 text-white flex flex-col items-center py-8">
    <div class="w-full max-w-2xl p-6 rounded-2xl shadow-2xl bg-white/10 backdrop-blur-md border border-white/20">
        <h2 class="text-2xl font-bold mb-4 text-center">Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Daily Calories & Macros -->
            <div class="rounded-xl bg-gray-900/70 p-4 shadow-lg flex flex-col items-center">
                <h3 class="font-semibold mb-2">Today's Nutrition</h3>
                <div class="flex flex-col items-center">
                    <span class="text-3xl font-bold">{{ $calories ?? '0' }} kcal</span>
                    <div class="flex gap-4 mt-2 text-sm">
                        <span>Protein: <b>{{ $protein ?? '0' }}g</b></span>
                        <span>Carbs: <b>{{ $carbs ?? '0' }}g</b></span>
                        <span>Fat: <b>{{ $fat ?? '0' }}g</b></span>
                    </div>
                </div>
            </div>
            <!-- Today's Workout -->
            <div class="rounded-xl bg-gray-900/70 p-4 shadow-lg flex flex-col items-center">
                <h3 class="font-semibold mb-2">Today's Workout</h3>
                <div>
                    @if(isset($workout))
                        <ul class="text-sm">
                            @foreach($workout['exercises'] as $exercise)
                                <li>{{ $exercise['name'] }}: {{ $exercise['sets'] }} x {{ $exercise['reps'] }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-gray-400">No workout scheduled.</span>
                    @endif
                </div>
            </div>
            <!-- Water Tracker -->
            <div class="rounded-xl bg-gray-900/70 p-4 shadow-lg flex flex-col items-center">
                <h3 class="font-semibold mb-2">Water Tracker</h3>
                <span class="text-2xl font-bold">{{ $water ?? '0' }} L</span>
            </div>
            <!-- Streak Counter -->
            <div class="rounded-xl bg-gray-900/70 p-4 shadow-lg flex flex-col items-center">
                <h3 class="font-semibold mb-2">Streak</h3>
                <span class="text-2xl font-bold">{{ $streak ?? '0' }} days</span>
            </div>
        </div>
        <!-- Weekly Summary Chart Placeholder -->
        <div class="mt-8 rounded-xl bg-gray-900/70 p-4 shadow-lg">
            <h3 class="font-semibold mb-2">Weekly Summary</h3>
            <div class="h-40 flex items-center justify-center text-gray-400">[Chart Coming Soon]</div>
        </div>
    </div>
</div>
@endsection
