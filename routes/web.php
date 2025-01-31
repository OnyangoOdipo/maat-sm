<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentPerformanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Simple dashboard routes without role middleware
    Route::get('/superadmin', [DashboardController::class, 'superadmin'])->name('superadmin.dashboard');
    Route::get('/schooladmin', [DashboardController::class, 'schooladmin'])->name('schooladmin.dashboard');
    Route::get('/teacher', [DashboardController::class, 'teacher'])->name('teacher.dashboard');

    // Schools management routes
    Route::resource('schools', SchoolController::class);

    // Student Management Routes
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/', [StudentController::class, 'store'])->name('students.store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        
        // Attendance routes
        Route::get('/{student}/attendance', [StudentAttendanceController::class, 'index'])->name('students.attendance');
        
        // Academic Performance routes
        Route::get('/{student}/performance', [StudentPerformanceController::class, 'index'])->name('students.performance');
    });

    // Class Management Routes - Moved outside students prefix
    Route::resource('classes', ClassController::class);

    // Teacher Management Routes
    Route::resource('teachers', TeacherController::class);

    // Subject Management Routes
    Route::resource('subjects', SubjectController::class);

    // School Types routes
    Route::get('/school-types', function () {
        return view('school.types');
    })->name('school.types');
});

require __DIR__.'/auth.php';
