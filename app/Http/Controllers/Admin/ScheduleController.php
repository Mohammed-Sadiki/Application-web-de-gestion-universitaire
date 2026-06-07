<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Group;
use App\Models\Module;
use App\Models\Professor;
use App\Models\Room;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['group', 'module', 'professor.user', 'room'])->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $groups = Group::all();
        $modules = Module::all();
        $professors = Professor::with('user')->get();
        $rooms = Room::all();
        return view('admin.schedules.create', compact('groups', 'modules', 'professors', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'module_id' => 'required|exists:modules,id',
            'professor_id' => 'required|exists:professors,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Check for room conflict
        $conflict = Schedule::where('room_id', $validated['room_id'])
            ->where('day', $validated['day'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['room_id' => 'La salle est déjà occupée sur ce créneau.'])->withInput();
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Emploi du temps mis à jour.');
    }

    public function edit(Schedule $schedule)
    {
        $groups = Group::all();
        $modules = Module::all();
        $professors = Professor::with('user')->get();
        $rooms = Room::all();
        return view('admin.schedules.edit', compact('schedule', 'groups', 'modules', 'professors', 'rooms'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'module_id' => 'required|exists:modules,id',
            'professor_id' => 'required|exists:professors,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Séance modifiée.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Séance supprimée.');
    }
}
