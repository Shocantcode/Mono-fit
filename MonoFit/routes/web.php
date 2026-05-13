<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ReminderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Workout
    Route::get('/workout', [WorkoutController::class, 'index'])->name('workout.index');

    // Nutrition
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');

    // Progress
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');

    // Reminder
    Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
    Route::get('/reminder/create', [ReminderController::class, 'create'])->name('reminder.create');
    Route::post('/reminder', [ReminderController::class, 'store'])->name('reminder.store');

    // Exercise Library
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');

    // Workout Schedule
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

    // Body Calculator
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
});

require __DIR__.'/auth.php';
