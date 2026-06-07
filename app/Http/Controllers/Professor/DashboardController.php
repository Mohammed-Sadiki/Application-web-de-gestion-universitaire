<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Module;
use App\Models\Absence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        
        $stats = [
            'modules' => $professor->modules()->count(),
            'schedules_today' => Schedule::where('professor_id', $professor->id)
                ->where('day', now()->format('l'))
                ->count(),
            'pending_absences' => Absence::whereIn('module_id', $professor->modules->pluck('id'))
                ->where('status', 'pending')
                ->count(),
        ];

        $todaySchedules = Schedule::where('professor_id', $professor->id)
            ->where('day', now()->format('l'))
            ->with(['module', 'group', 'room'])
            ->get();

        return view('professor.dashboard', compact('stats', 'todaySchedules'));
    }
}
