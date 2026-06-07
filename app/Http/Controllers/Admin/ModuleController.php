<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Department;
use App\Models\Professor;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('department')->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $departments = Department::all();
        $professors = Professor::with('user')->get();
        return view('admin.modules.create', compact('departments', 'professors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'professors' => 'array',
            'professors.*' => 'exists:professors,id',
        ]);

        $module = Module::create([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
        ]);

        if (isset($validated['professors'])) {
            $module->professors()->sync($validated['professors']);
        }

        return redirect()->route('admin.modules.index')->with('success', 'Module créé avec succès.');
    }

    public function edit(Module $module)
    {
        $departments = Department::all();
        $professors = Professor::with('user')->get();
        return view('admin.modules.edit', compact('module', 'departments', 'professors'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'professors' => 'array',
            'professors.*' => 'exists:professors,id',
        ]);

        $module->update([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
        ]);

        if (isset($validated['professors'])) {
            $module->professors()->sync($validated['professors']);
        }

        return redirect()->route('admin.modules.index')->with('success', 'Module mis à jour.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé.');
    }
}
