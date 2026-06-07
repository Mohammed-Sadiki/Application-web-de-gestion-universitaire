<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Module;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $professor = auth()->user()->professor;
        $announcements = $professor->announcements()->with('module')->get();
        return view('professor.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $professor = auth()->user()->professor;
        $modules = $professor->modules;
        return view('professor.announcements.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'content' => 'required|string',
        ]);

        $professor = auth()->user()->professor;
        $professor->announcements()->create($validated);

        return redirect()->route('professor.announcements.index')->with('success', 'Annonce publiée.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('professor.announcements.index')->with('success', 'Annonce supprimée.');
    }
}
