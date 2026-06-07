<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->isStudent()) {
            $grades = $user->student->grades()->with('module')->get();
            return response()->json($grades);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
