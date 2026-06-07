<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $schedules = Schedule::where('group_id', $student->group_id)
            ->with(['module', 'professor.user', 'room'])
            ->get();
        return view('student.schedules.index', compact('schedules'));
    }
}
