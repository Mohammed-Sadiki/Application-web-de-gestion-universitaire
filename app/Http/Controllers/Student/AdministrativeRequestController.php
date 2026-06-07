<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeRequest;
use Illuminate\Http\Request;

class AdministrativeRequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->administrativeRequests;
        return view('student.requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:Attestation de scolarité,Relevé de notes,Certificat d\'inscription',
        ]);

        auth()->user()->administrativeRequests()->create($validated);

        return redirect()->route('student.requests.index')->with('success', 'Demande soumise.');
    }
}
