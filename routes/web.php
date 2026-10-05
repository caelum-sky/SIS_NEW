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
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => url('/login'), 'changefreq' => 'monthly', 'priority' => '0.5'],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
    foreach ($urls as $u) {
        $xml .= '<url><loc>' . e($u['loc']) . '</loc><changefreq>' . $u['changefreq'] . '</changefreq><priority>' . $u['priority'] . '</priority></url>' . PHP_EOL;
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/requirements', [RequirementSubmissionController::class, 'studentIndex'])->name('requirements.index');
    Route::post('/requirements', [RequirementSubmissionController::class, 'store'])->name('requirements.store');
    Route::get('/cor/download', [CorController::class, 'download'])->name('cor.download');
});

Route::middleware(['auth:web', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
