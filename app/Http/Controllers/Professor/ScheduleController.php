<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $schedules = Schedule::with(['group', 'module', 'room'])
            ->where('professor_id', $professor->id)
            ->orderByRaw("FIELD(day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')")
            ->orderBy('start_time')
            ->get();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $byDay = [];
        foreach ($days as $day) {
            $byDay[$day] = $schedules->where('day', $day)->values();
        }

        return view('professor.schedules.index', compact('byDay', 'days'));
    }
}
