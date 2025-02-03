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
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteStopController;
use App\Http\Controllers\RouteAssignmentController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\Auth\LoginController;
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

    // Transport Management Routes
    Route::prefix('transport')->name('transport.')->group(function () {
        Route::resource('vehicles', VehicleController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('routes', RouteController::class);
        Route::resource('route-stops', RouteStopController::class)->except(['index']);
        Route::resource('route-assignments', RouteAssignmentController::class);
    });

    // Timeslots routes
    Route::get('/timeslots', [TimeSlotController::class, 'index'])->name('timeslots.index');
    Route::get('/timeslots/create', [TimeSlotController::class, 'create'])->name('timeslots.create');
    Route::post('/timeslots/generate', [TimeSlotController::class, 'generateTimeslots'])->name('timeslots.generate');
    Route::post('/timeslots', [TimeSlotController::class, 'store'])->name('timeslots.store');

    // Timetable routes
    Route::prefix('timetables')->name('timetables.')->group(function () {
        Route::get('/', [TimetableController::class, 'index'])->name('index');
        Route::get('/create', [TimetableController::class, 'create'])->name('create');
        Route::post('/generate', [TimetableController::class, 'generate'])->name('generate');
        Route::get('/{timetable}', [TimetableController::class, 'show'])->name('show');
    });

    // Roles and Permissions routes
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles.permissions');
    Route::get('/assign-permissions', [RolePermissionController::class, 'assignRolesView'])->name('assign.permissions')->middleware('role:Admin'); // Example of using role middleware
    
    // TODO: Move the following routes to an API route file
    Route::post('/api/assign-roles', [RolePermissionController::class, 'assignRoles'])->name('assign.role');
    Route::post('/api/{type}/store', [RolePermissionController::class, 'storePermissionOrRole'])->name('permissions.store');
    Route::post('/api/roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::delete('/api/permissions/{permission}', [RolePermissionController::class, 'deletePermission'])->name('permissions.delete');
});

require __DIR__ . '/auth.php';
