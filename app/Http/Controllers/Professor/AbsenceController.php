<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $modules = $professor->modules;
        return view('professor.absences.index', compact('modules'));
    }

    public function create(Module $module)
    {
        $students = $module->department->groups->flatMap->students;
        return view('professor.absences.create', compact('module', 'students'));
    }

    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'absent_students' => 'array',
            'absent_students.*' => 'exists:students,id',
        ]);

        if (isset($validated['absent_students'])) {
            foreach ($validated['absent_students'] as $studentId) {
                Absence::create([
                    'student_id' => $studentId,
                    'module_id' => $module->id,
                    'date' => $validated['date'],
                    'status' => 'pending'
                ]);
            }
        }

        return redirect()->route('professor.absences.index')->with('success', 'Absences enregistrées.');
    }
}
