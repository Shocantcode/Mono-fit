<?php

namespace App\Http\Controllers;

class ExerciseController extends Controller
{
    public function index()
    {
        return view('exercises.index');
    }
}
