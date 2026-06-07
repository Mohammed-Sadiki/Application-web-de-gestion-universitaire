<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public API login endpoint - returns Sanctum token
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user  = Auth::user();
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'role'  => $user->role,
        'name'  => $user->name,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/grades', [App\Http\Controllers\Api\GradeController::class, 'index']);
    Route::get('/schedules', [App\Http\Controllers\Api\ScheduleController::class, 'index']);
    Route::get('/absences', [App\Http\Controllers\Api\AbsenceController::class, 'index']);
    Route::get('/modules', [App\Http\Controllers\Api\ModuleController::class, 'index']);
});

