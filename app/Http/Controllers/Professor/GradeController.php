<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $modules = $professor->modules;
        return view('professor.grades.index', compact('modules'));
    }

    public function edit(Module $module)
    {
        $students = $module->department->groups->flatMap->students;
        return view('professor.grades.edit', compact('module', 'students'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.cc1' => 'nullable|numeric|min:0|max:20',
            'grades.*.cc2' => 'nullable|numeric|min:0|max:20',
            'grades.*.exam' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            $cc1 = $gradeData['cc1'] ?? 0;
            $cc2 = $gradeData['cc2'] ?? 0;
            $exam = $gradeData['exam'] ?? 0;
            
            // Formula: (CC1 + CC2)/2 * 0.4 + Examen * 0.6
            $finalGrade = (($cc1 + $cc2) / 2) * 0.4 + ($exam * 0.6);

            Grade::updateOrCreate(
                ['module_id' => $module->id, 'student_id' => $gradeData['student_id']],
                [
                    'cc1' => $cc1,
                    'cc2' => $cc2,
                    'exam' => $exam,
                    'final_grade' => $finalGrade
                ]
            );
        }

        return redirect()->route('professor.grades.index')->with('success', 'Notes mises à jour.');
    }
}
