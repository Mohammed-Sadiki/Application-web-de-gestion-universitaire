<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $materials = $professor->courseMaterials()->with('module')->get();
        return view('professor.materials.index', compact('materials'));
    }

    public function create()
    {
        $professor = auth()->user()->professor;
        $modules = $professor->modules;
        return view('professor.materials.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,pptx,docx,zip|max:10240',
        ]);

        $path = $request->file('file')->store('materials', 'public');

        $professor = auth()->user()->professor;
        $professor->courseMaterials()->create([
            'module_id' => $validated['module_id'],
            'title' => $validated['title'],
            'file_path' => $path,
            'type' => strtoupper($request->file('file')->getClientOriginalExtension()),
        ]);

        return redirect()->route('professor.materials.index')->with('success', 'Support de cours ajouté.');
    }

    public function destroy(CourseMaterial $material)
    {
        Storage::disk('public')->delete($material->file_path);
        $material->delete();
        return redirect()->route('professor.materials.index')->with('success', 'Support supprimé.');
    }
}
