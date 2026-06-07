<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\RoomReservation;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomReservationController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $reservations = $professor->reservations()->with('room')->get();
        return view('professor.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('professor.reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'reason' => 'nullable|string',
        ]);

        // Check for conflicts
        $conflict = RoomReservation::where('room_id', $validated['room_id'])
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['room_id' => 'La salle est déjà réservée sur ce créneau.'])->withInput();
        }

        $professor = auth()->user()->professor;
        $professor->reservations()->create($validated);

        return redirect()->route('professor.reservations.index')->with('success', 'Réservation effectuée.');
    }
}
