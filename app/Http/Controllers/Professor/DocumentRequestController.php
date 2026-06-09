<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;

        if (!$professor) {
            abort(403, "Vous n'avez pas de profil professeur.");
        }

        // Get requests transferred to this professor
        $requests = AdministrativeRequest::where('professor_id', $professor->id)
            ->where('status', 'transferred')
            ->with('user')
            ->get();

        return view('professor.documents.index', compact('requests'));
    }

    public function upload(Request $request, AdministrativeRequest $adminRequest)
    {
        $professor = auth()->user()->professor;

        if (!$professor || $adminRequest->professor_id !== $professor->id) {
            abort(403, "Action non autorisée.");
        }

        $request->validate([
            'document' => 'required|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:10240',
        ]);

        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($adminRequest->file_path) {
                Storage::disk('public')->delete($adminRequest->file_path);
            }

            $file = $request->file('document');
            $path = $file->storeAs(
                'documents',
                'doc_' . $adminRequest->id . '.' . $file->getClientOriginalExtension(),
                'public'
            );

            $adminRequest->update([
                'status' => 'validated',
                'file_path' => $path,
                'reason' => 'Document téléversé par le professeur.',
            ]);

            return back()->with('success', 'Document téléversé et demande validée.');
        }

        return back()->withErrors(['document' => 'Veuillez sélectionner un fichier valide.']);
    }
}
