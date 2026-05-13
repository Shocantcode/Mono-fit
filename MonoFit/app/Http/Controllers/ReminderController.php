<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Auth::user()->reminders()->orderBy('time')->get();
        return view('reminder.index', compact('reminders'));
    }

    public function create()
    {
        return view('reminder.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:workout,meal,water,custom',
            'time' => 'required|date_format:H:i',
            'message' => 'required|string|max:255',
        ]);

        Auth::user()->reminders()->create($request->only(['type', 'time', 'message']));

        return redirect()->route('reminder.index')->with('success', 'Reminder created successfully.');
    }
}
