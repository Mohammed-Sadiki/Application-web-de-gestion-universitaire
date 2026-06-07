<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Student;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with(['student.user', 'module'])
            ->where('justified', true)
            ->orderBy('status')
            ->get();
        return view('admin.absences.index', compact('absences'));
    }

    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'status' => 'required|in:validated,rejected',
        ]);

        $absence->update($validated);

        return back()->with('success', 'Justificatif ' . ($validated['status'] === 'validated' ? 'validé' : 'refusé') . '.');
    }
}
