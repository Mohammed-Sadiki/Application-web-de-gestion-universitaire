<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:Cours,Labo',
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Salle créée avec succès.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:Cours,Labo',
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Salle mise à jour.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Salle supprimée.');
    }
}
