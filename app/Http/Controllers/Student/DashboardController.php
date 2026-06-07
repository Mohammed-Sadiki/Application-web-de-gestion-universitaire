<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Absence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        $stats = [
            'moyenne_generale' => number_format($student->grades()->avg('final_grade'), 2),
            'absences_totales' => $student->absences()->count(),
            'modules_suivis' => $student->group->department->modules()->count(),
        ];

        $nextSessions = Schedule::where('group_id', $student->group_id)
            ->where('day', now()->format('l'))
            ->where('start_time', '>', now()->format('H:i:s'))
            ->with(['module', 'professor.user', 'room'])
            ->get();

        return view('student.dashboard', compact('stats', 'nextSessions'));
    }
}
