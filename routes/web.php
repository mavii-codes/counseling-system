<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CounselingCaseController;
use App\Http\Controllers\CounselingSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/students/export', [ExportController::class, 'students'])->name('students.export');
    Route::resource('students', StudentController::class);

    Route::get('/counseling-cases/export', [ExportController::class, 'cases'])->name('counseling-cases.export');
    Route::get('/counseling-cases/{counseling_case}/report', [CounselingCaseController::class, 'report'])
        ->name('counseling-cases.report');
    Route::resource('counseling-cases', CounselingCaseController::class);

    Route::get('/sessions/history', [CounselingSessionController::class, 'timeline'])->name('sessions.timeline');
    Route::resource('counseling-cases.sessions', CounselingSessionController::class);
});
