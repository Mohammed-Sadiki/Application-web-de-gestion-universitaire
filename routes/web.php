<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('set-locale');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return view('crm_dashboard');
        } elseif (auth()->user()->isProfessor()) {
            return redirect()->route('professor.dashboard');
        } elseif (auth()->user()->isStudent()) {
            return redirect()->route('student.dashboard');
        }
        return abort(403);
    })->name('dashboard');

    Route::get('/crm', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        } elseif (auth()->user()->isProfessor()) {
            return redirect()->route('professor.dashboard');
        } elseif (auth()->user()->isStudent()) {
            return redirect()->route('student.dashboard');
        }
        return abort(403);
    })->name('crm.dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::patch('/requests/{adminRequest}', [App\Http\Controllers\Admin\DashboardController::class, 'validateRequest'])->name('requests.validate');
        Route::post('/requests/{adminRequest}/upload', [App\Http\Controllers\Admin\DashboardController::class, 'uploadDocument'])->name('requests.upload');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
        Route::resource('groups', App\Http\Controllers\Admin\GroupController::class);
        Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class);
        Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);

        // Absences management (validate/reject justifications)
        Route::get('/absences', [App\Http\Controllers\Admin\AbsenceController::class, 'index'])->name('absences.index');
        Route::patch('/absences/{absence}', [App\Http\Controllers\Admin\AbsenceController::class, 'update'])->name('absences.update');

        // Lesson Logs (read all)
        Route::get('/lesson_logs', [App\Http\Controllers\Admin\LessonLogController::class, 'index'])->name('lesson_logs.index');

        // Reservations management (full control)
        Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class);
    });

    // Professor Routes
    Route::middleware(['role:professor'])->prefix('professor')->name('professor.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Professor\DashboardController::class, 'index'])->name('dashboard');

        // Grades
        Route::get('/grades', [App\Http\Controllers\Professor\GradeController::class, 'index'])->name('grades.index');
        Route::get('/grades/{module}/edit', [App\Http\Controllers\Professor\GradeController::class, 'edit'])->name('grades.edit');
        Route::patch('/grades/{module}', [App\Http\Controllers\Professor\GradeController::class, 'update'])->name('grades.update');

        // Absences
        Route::get('/absences', [App\Http\Controllers\Professor\AbsenceController::class, 'index'])->name('absences.index');
        Route::get('/absences/{module}/create', [App\Http\Controllers\Professor\AbsenceController::class, 'create'])->name('absences.create');
        Route::post('/absences/{module}', [App\Http\Controllers\Professor\AbsenceController::class, 'store'])->name('absences.store');

        // Lesson Logs
        Route::resource('lesson_logs', App\Http\Controllers\Professor\LessonLogController::class);

        // Materials & Announcements
        Route::resource('materials', App\Http\Controllers\Professor\CourseMaterialController::class);
        Route::resource('announcements', App\Http\Controllers\Professor\AnnouncementController::class);

        // Reservations
        Route::resource('reservations', App\Http\Controllers\Professor\RoomReservationController::class);

        // Schedule (personal timetable)
        Route::get('/schedules', [App\Http\Controllers\Professor\ScheduleController::class, 'index'])->name('schedules.index');

        // Administrative Requests (Attestation de travail, Ordre de mission)
        Route::get('/requests', [App\Http\Controllers\Professor\RequestController::class, 'index'])->name('requests.index');
        Route::post('/requests', [App\Http\Controllers\Professor\RequestController::class, 'store'])->name('requests.store');

        // Transferred Document Requests
        Route::get('/documents', [App\Http\Controllers\Professor\DocumentRequestController::class, 'index'])->name('documents.index');
        Route::patch('/documents/{adminRequest}/upload', [App\Http\Controllers\Professor\DocumentRequestController::class, 'upload'])->name('documents.upload');
    });

    // Student Routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

        // Grades
        Route::get('/grades', [App\Http\Controllers\Student\GradeController::class, 'index'])->name('grades.index');

        // Absences
        Route::get('/absences', [App\Http\Controllers\Student\AbsenceController::class, 'index'])->name('absences.index');
        Route::patch('/absences/{absence}', [App\Http\Controllers\Student\AbsenceController::class, 'update'])->name('absences.update');

        // Schedule
        Route::get('/schedules', [App\Http\Controllers\Student\ScheduleController::class, 'index'])->name('schedules.index');

        // Administrative Requests
        Route::get('/requests', [App\Http\Controllers\Student\AdministrativeRequestController::class, 'index'])->name('requests.index');
        Route::post('/requests', [App\Http\Controllers\Student\AdministrativeRequestController::class, 'store'])->name('requests.store');
    });

    // Classroom routes (shared by student and professor)
    Route::get('/courses', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{module}', [App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
    Route::post('/announcements/{announcement}/comment', [App\Http\Controllers\Student\CourseController::class, 'comment'])->name('courses.comment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
