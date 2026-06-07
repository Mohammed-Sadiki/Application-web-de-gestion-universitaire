<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->administrativeRequests;
        return view('professor.requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:Attestation de travail,Ordre de mission',
            'destination' => 'nullable|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'motif'       => 'nullable|string|max:1000',
        ]);

        $type = $validated['type'];
        $details = null;

        if ($type === 'Ordre de mission') {
            $request->validate([
                'destination' => 'required|string|max:255',
                'start_date'  => 'required|date',
                'end_date'    => 'required|date|after_or_equal:start_date',
                'motif'       => 'required|string|max:1000',
            ]);
            $details = json_encode([
                'destination' => $validated['destination'],
                'start_date'  => $validated['start_date'],
                'end_date'    => $validated['end_date'],
                'motif'       => $validated['motif'],
            ]);
        }

        auth()->user()->administrativeRequests()->create([
            'type'    => $type,
            'reason'  => $details,
            'status'  => 'pending',
        ]);

        return redirect()->route('professor.requests.index')->with('success', 'Demande soumise avec succès.');
    }
}
