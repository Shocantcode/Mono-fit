<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Exercise::query();

        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        $exercises = $query->orderBy('category')->orderBy('name')->get();
        $categories = Exercise::select('category')->distinct()->pluck('category');

        return view('exercises.index', compact('exercises', 'categories', 'category', 'search'));
    }
}
