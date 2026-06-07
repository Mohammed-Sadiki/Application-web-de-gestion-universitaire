<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeRequest;
use App\Models\User;
use App\Models\Department;
use App\Models\Group;
use App\Models\Module;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        return view('admin.dashboard', compact('stats', 'pendingRequests'));
    }

    public function validateRequest(Request $request, AdministrativeRequest $adminRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:validated,rejected',
            'reason' => 'nullable|string',
        ]);

        $adminRequest->update($validated);

        if ($validated['status'] === 'validated') {
            // Generate PDF
            $pdf = Pdf::loadView('pdfs.document', ['request' => $adminRequest]);
            $path = 'documents/doc_' . $adminRequest->id . '.pdf';
            Storage::disk('public')->put($path, $pdf->output());
            $adminRequest->update(['file_path' => $path]);
        }

        return back()->with('success', 'Demande traitée.');
    }
}
