<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Department;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('department')->get();
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.groups.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Group::create($validated);

        return redirect()->route('admin.groups.index')->with('success', 'Groupe créé avec succès.');
    }

    public function edit(Group $group)
    {
        $departments = Department::all();
        return view('admin.groups.edit', compact('group', 'departments'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $group->update($validated);

        return redirect()->route('admin.groups.index')->with('success', 'Groupe mis à jour.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Groupe supprimé.');
    }
}
