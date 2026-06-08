<?php

use App\Http\Controllers\CorController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\InterviewScheduleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequirementSubmissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web', 'verified'])->name('dashboard');

Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requirements', [RequirementSubmissionController::class, 'studentIndex'])->name('requirements.index');
    Route::post('/requirements', [RequirementSubmissionController::class, 'store'])->name('requirements.store');
    Route::get('/cor/download', [CorController::class, 'download'])->name('cor.download');
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::resource('/students', StudentController::class);
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/grade', GradeController::class);
    Route::resource('/student/enroll', EnrollmentController::class);
    Route::get('/student/{student_id}/subjects', [EnrollmentController::class, 'getSubjects'])
        ->name('enrollment.subjects');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/requirements', [RequirementSubmissionController::class, 'adminIndex'])->name('requirements.index');
        Route::patch('/requirements/{requirement}', [RequirementSubmissionController::class, 'review'])->name('requirements.review');
    });

    Route::prefix('admin/interviews')->name('interviews.')->group(function () {
        Route::get('/', [InterviewScheduleController::class, 'index'])->name('index');
        Route::get('/events', [InterviewScheduleController::class, 'events'])->name('events');
        Route::post('/', [InterviewScheduleController::class, 'store'])->name('store');
        Route::put('/{interview}', [InterviewScheduleController::class, 'update'])->name('update');
        Route::delete('/{interview}', [InterviewScheduleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/students', [ModuleController::class, 'studentProfiles'])->name('students.index');
        Route::get('/students/{student}', [ModuleController::class, 'showStudentProfile'])->name('students.show');
        Route::get('/academic-history', [ModuleController::class, 'academicHistory'])->name('academic-history');
        Route::get('/admissions', [ModuleController::class, 'admissions'])->name('admissions');
        Route::get('/scheduling', [ModuleController::class, 'scheduling'])->name('scheduling');
        Route::get('/attendance', [ModuleController::class, 'attendance'])->name('attendance');
        Route::get('/billing', [ModuleController::class, 'billing'])->name('billing');
        Route::get('/reports', [ModuleController::class, 'reports'])->name('reports');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
