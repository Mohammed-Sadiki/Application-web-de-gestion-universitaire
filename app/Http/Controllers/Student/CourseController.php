<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isStudent()) {
            $modules = $user->student->group->department->modules;
        } else if ($user->isProfessor()) {
            $modules = $user->professor->modules;
        } else {
            $modules = collect();
        }
        return view('student.courses.index', compact('modules'));
    }

    public function show(Module $module)
    {
        $materials = $module->courseMaterials;
        $announcements = $module->announcements()->with(['professor.user', 'comments.user'])->latest()->get();
        return view('student.courses.show', compact('module', 'materials', 'announcements'));
    }

    public function comment(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $announcement->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Commentaire ajouté.');
    }
}
