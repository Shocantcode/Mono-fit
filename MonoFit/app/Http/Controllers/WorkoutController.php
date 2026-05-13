<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $workout = $user->workouts()->whereDate('date', today())->first();

        return view('workout.index', compact('workout'));
    }
}
