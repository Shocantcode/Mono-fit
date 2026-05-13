<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get current streak from the most recent progress record
        $streak = optional(
            $user->progresses()->orderByDesc('date')->first()
        )->streak ?? 0;

        return view('progress.index', compact('streak'));
    }
}
