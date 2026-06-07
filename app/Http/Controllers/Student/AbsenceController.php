<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $absences = $student->absences()->with('module')->get();
        return view('student.absences.index', compact('absences'));
    }

    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'justification' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('justification')->store('justifications', 'public');

        $absence->update([
            'justified' => true,
            'justification_path' => $path,
            'status' => 'pending'
        ]);

        return redirect()->route('student.absences.index')->with('success', 'Justificatif déposé.');
    }
}
