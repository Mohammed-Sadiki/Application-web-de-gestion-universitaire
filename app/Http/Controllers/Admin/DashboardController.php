<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeRequest;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Department;
use App\Models\Group;
use App\Models\Module;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'departments' => Department::count(),
            'groups' => Group::count(),
            'modules' => Module::count(),
            'rooms' => Room::count(),
            'pending_requests' => AdministrativeRequest::where('status', 'pending')->count(),
        ];
        
        $pendingRequests = AdministrativeRequest::where('status', 'pending')->with('user')->get();
        $transferredRequests = AdministrativeRequest::where('status', 'transferred')->with(['user', 'professor.user'])->get();
        
        return view('admin.dashboard', compact('stats', 'pendingRequests', 'transferredRequests'));
    }

    public function validateRequest(Request $request, AdministrativeRequest $adminRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:validated,rejected',
            'reason' => 'nullable|string',
        ]);

        if ($validated['status'] === 'rejected') {
            $adminRequest->update([
                'status' => 'rejected',
                'reason' => $validated['reason'] ?? null,
            ]);
            return back()->with('success', 'Demande rejetée.');
        }

        // Auto-detect concerned professor
        $professorId = null;
        if ($adminRequest->user->isStudent()) {
            $student = $adminRequest->user->student;
            if ($student && $student->group_id) {
                $schedule = Schedule::where('group_id', $student->group_id)->first();
                if ($schedule) {
                    $professorId = $schedule->professor_id;
                }
            }
        } elseif ($adminRequest->user->isProfessor()) {
            $professor = $adminRequest->user->professor;
            if ($professor) {
                $professorId = $professor->id;
            }
        }

        if (!$professorId) {
            $firstProf = \App\Models\Professor::first();
            if ($firstProf) {
                $professorId = $firstProf->id;
            }
        }

        $adminRequest->update([
            'status' => 'transferred',
            'professor_id' => $professorId,
            'reason' => 'Transféré automatiquement au professeur concerné.',
        ]);

        return back()->with('success', 'Demande transférée au professeur concerné.');
    }

    public function uploadDocument(Request $request, AdministrativeRequest $adminRequest)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:10240',
        ]);

        if ($adminRequest->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($adminRequest->file_path);
        }

        $file = $request->file('document');
        $path = $file->storeAs(
            'documents',
            'doc_' . $adminRequest->id . '.' . $file->getClientOriginalExtension(),
            'public'
        );

        $adminRequest->update([
            'status'    => 'validated',
            'file_path' => $path,
            'reason'    => 'Document téléversé et validé par l\'administrateur.',
        ]);

        return back()->with('success', 'Document téléversé et demande validée avec succès.');
    }
}
