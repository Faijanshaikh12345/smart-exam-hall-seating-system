
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRegistrationController;
use App\Http\Controllers\ExamHallController;
use App\Http\Controllers\HallSeatController;
use App\Http\Controllers\SeatingArrangementController;
use App\Http\Controllers\ConflictController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\StaffPortalController;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/exams', [StudentPortalController::class, 'exams'])->name('exams');
        Route::get('/seating', [StudentPortalController::class, 'seating'])->name('seating');
        Route::get('/profile', [StudentPortalController::class, 'profile'])->name('profile');
    });

    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/exam-duties', [StaffPortalController::class, 'examDuties'])->name('exam-duties');
        Route::get('/exam-duties/{exam}', [StaffPortalController::class, 'showExam'])->name('exam-duties.show');
        Route::get('/seating', [StaffPortalController::class, 'seating'])->name('seating');
        Route::get('/conflicts', [StaffPortalController::class, 'conflicts'])->name('conflicts.index');
        Route::get('/conflicts/create', [StaffPortalController::class, 'createConflict'])->name('conflicts.create');
        Route::post('/conflicts', [StaffPortalController::class, 'storeConflict'])->name('conflicts.store');
        Route::get('/conflicts/{conflict}', [StaffPortalController::class, 'showConflict'])->name('conflicts.show');
        Route::get('/profile', [StaffPortalController::class, 'profile'])->name('profile');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('students', StudentController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('exams', ExamController::class);
        Route::resource('exam-registrations', ExamRegistrationController::class);
        Route::resource('exam-halls', ExamHallController::class);
        Route::resource('hall-seats', HallSeatController::class);
        Route::resource('seating-arrangements', SeatingArrangementController::class);
        Route::resource('conflicts', ConflictController::class);
        Route::resource('settings', SettingController::class);
        Route::resource('users', UserController::class);
    });
});
