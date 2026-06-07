<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->isStudent()) {
            $schedules = Schedule::where('group_id', $user->student->group_id)
                ->with(['module', 'professor.user', 'room'])
                ->get();
        } elseif ($user->isProfessor()) {
            $schedules = Schedule::where('professor_id', $user->professor->id)
                ->with(['module', 'group', 'room'])
                ->get();
        } else {
            $schedules = Schedule::with(['module', 'group', 'professor.user', 'room'])->get();
        }
        
        return response()->json($schedules);
    }
}
