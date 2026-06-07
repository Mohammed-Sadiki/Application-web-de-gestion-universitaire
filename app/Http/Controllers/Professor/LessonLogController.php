<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\LessonLog;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonLogController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $logs = $professor->lessonLogs()->with('module')->get();
        return view('professor.lesson_logs.index', compact('logs'));
    }

    public function create()
    {
        $professor = auth()->user()->professor;
        $modules = $professor->modules;
        return view('professor.lesson_logs.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'objective' => 'required|string',
            'type' => 'required|in:Cours,TD,TP',
        ]);

        $professor = auth()->user()->professor;
        $professor->lessonLogs()->create($validated);

        return redirect()->route('professor.lesson_logs.index')->with('success', 'Cahier de textes mis à jour.');
    }
}
