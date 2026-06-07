<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomReservation;
use App\Models\Room;
use App\Models\Professor;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = RoomReservation::with(['professor.user', 'room'])
            ->orderBy('date', 'desc')
            ->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function edit(RoomReservation $reservation)
    {
        $rooms = Room::all();
        return view('admin.reservations.edit', compact('reservation', 'rooms'));
    }

    public function update(Request $request, RoomReservation $reservation)
    {
        $validated = $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation modifiée.');
    }

    public function destroy(RoomReservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Réservation annulée.');
    }
}
