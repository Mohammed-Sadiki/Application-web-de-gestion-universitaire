<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonLog;

class LessonLogController extends Controller
{
    public function index()
    {
        $logs = LessonLog::with(['professor.user', 'module'])
            ->orderBy('date', 'desc')
            ->get();
        return view('admin.lesson_logs.index', compact('logs'));
    }
}
