<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PengajarController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('home');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Siswa (Student) Routes
    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/profile', [SiswaController::class, 'profile'])->name('siswa.profile');
        Route::post('/profile', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
        Route::get('/courses', [SiswaController::class, 'courses'])->name('siswa.courses.index');
        Route::get('/courses/explore', [SiswaController::class, 'explore'])->name('siswa.courses.explore');
        Route::post('/courses/{course}/enroll', [SiswaController::class, 'enroll'])->name('siswa.courses.enroll');
        Route::get('/courses/{course}', [SiswaController::class, 'courseShow'])->name('siswa.courses.show');
        Route::post('/courses/{course}/unenroll', [SiswaController::class, 'unenroll'])->name('siswa.courses.unenroll');
        Route::get('/materials/{material}', [SiswaController::class, 'materialShow'])->name('siswa.materials.show');
        Route::post('/materials/{material}/complete', [SiswaController::class, 'materialComplete'])->name('siswa.materials.complete');
        Route::get('/assignments/{assignment}', [SiswaController::class, 'assignmentShow'])->name('siswa.assignments.show');
        Route::post('/assignments/{assignment}/submit', [SiswaController::class, 'assignmentSubmit'])->name('siswa.assignments.submit');
        Route::get('/schedule', [SiswaController::class, 'schedule'])->name('siswa.schedule.index');
    });

    // Pengajar (Teacher) Routes
    Route::middleware('role:pengajar')->prefix('pengajar')->group(function () {
        Route::get('/dashboard', [PengajarController::class, 'dashboard'])->name('pengajar.dashboard');
        
        // Course CRUD
        Route::get('/courses', [PengajarController::class, 'coursesIndex'])->name('pengajar.courses.index');
        Route::get('/courses/create', [PengajarController::class, 'coursesCreate'])->name('pengajar.courses.create');
        Route::post('/courses', [PengajarController::class, 'coursesStore'])->name('pengajar.courses.store');
        Route::get('/courses/{course}', [PengajarController::class, 'coursesShow'])->name('pengajar.courses.show');
        Route::get('/courses/{course}/edit', [PengajarController::class, 'coursesEdit'])->name('pengajar.courses.edit');
        Route::put('/courses/{course}', [PengajarController::class, 'coursesUpdate'])->name('pengajar.courses.update');
        Route::delete('/courses/{course}', [PengajarController::class, 'coursesDestroy'])->name('pengajar.courses.destroy');
        Route::delete('/courses/{course}/kick/{student}', [PengajarController::class, 'kickStudent'])->name('pengajar.courses.kick');

        // Material inside Course
        Route::post('/courses/{course}/materials', [PengajarController::class, 'storeMaterial'])->name('pengajar.materials.store');
        Route::put('/materials/{material}', [PengajarController::class, 'updateMaterial'])->name('pengajar.materials.update');
        Route::delete('/materials/{material}', [PengajarController::class, 'destroyMaterial'])->name('pengajar.materials.destroy');

        // Assignment inside Course
        Route::post('/courses/{course}/assignments', [PengajarController::class, 'storeAssignment'])->name('pengajar.assignments.store');
        Route::put('/assignments/{assignment}', [PengajarController::class, 'updateAssignment'])->name('pengajar.assignments.update');
        Route::delete('/assignments/{assignment}', [PengajarController::class, 'destroyAssignment'])->name('pengajar.assignments.destroy');

        // Submissions & Grading
        Route::get('/submissions', [PengajarController::class, 'submissionsIndex'])->name('pengajar.submissions.index');
        Route::post('/submissions/{submission}/grade', [PengajarController::class, 'gradeSubmission'])->name('pengajar.submissions.grade');

        // Schedule Builder
        Route::get('/schedule', [PengajarController::class, 'scheduleIndex'])->name('pengajar.schedule.index');
        Route::post('/courses/{course}/schedules', [PengajarController::class, 'storeSchedule'])->name('pengajar.schedules.store');
        Route::put('/schedules/{schedule}', [PengajarController::class, 'updateSchedule'])->name('pengajar.schedules.update');
        Route::delete('/schedules/{schedule}', [PengajarController::class, 'destroySchedule'])->name('pengajar.schedules.destroy');

        // Profile
        Route::get('/profile', [PengajarController::class, 'profile'])->name('pengajar.profile');
        Route::post('/profile', [PengajarController::class, 'updateProfile'])->name('pengajar.profile.update');
    });
});
