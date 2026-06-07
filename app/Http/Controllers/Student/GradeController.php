<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $grades = $student->grades()->with('module')->get();
        return view('student.grades.index', compact('grades'));
    }
}
