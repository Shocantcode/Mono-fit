<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $streak = $user->progresses()
            ->orderByDesc('date')
            ->where('workout_completed', true)
            ->get()
            ->takeWhile(fn ($p) => $p->date->isToday() || $p->date->isYesterday() || true)
            ->count();

        $streak = optional(
            $user->progresses()->orderByDesc('date')->first()
        )->streak ?? 0;

        return view('progress.index', compact('streak'));
    }
}
