<?php

use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\SeasonController;
use App\Http\Controllers\Panel\LanguageController;
use App\Http\Controllers\Panel\ChartController;
use App\Http\Controllers\Panel\SendController;

Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/auth', [AuthController::class, 'login'])->name('login');

Route::middleware('simple.auth')->group(function () {

    Route::get('logs', [LogViewerController::class, 'index']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/panel', [DashboardController::class, 'index']);
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::get('/users/{id}', [UserController::class, 'usersDetail'])->name('users.detail');
    Route::get('/users/ban/{id}', [UserController::class, 'banUser'])->name('users.ban');
    Route::get('/users/unban/{id}', [UserController::class, 'unbanUser'])->name('users.unban');
    Route::get('/users/referrals/{id}', [UserController::class, 'referrals'])->name('users.referrals');
    Route::get('/users/game_stats/{id}', [UserController::class, 'gameStats'])->name('users.game_stats');

    Route::get('/sends/stop/{id}', [SendController::class, 'stop'])->name('sends.stop');
    Route::get('/sends/delete_messages/{id}', [SendController::class, 'delete_messages'])->name('sends.delete_messages');
    Route::get('/sends', [SendController::class, 'index'])->name('sends');
    Route::get('/sends/add', [SendController::class, 'add'])->name('sends.add');
    Route::post('/sends/add', [SendController::class, 'add_'])->name('sends.add_');
    Route::get('/sends/{id}', [SendController::class, 'detail'])->name('sends.detail');
    Route::post('/sends/{id}', [SendController::class, 'detail_'])->name('sends.detail_');


    Route::get('/seasons/active/{id}', [SeasonController::class, 'active'])->name('seasons.active');
    Route::get('/seasons', [SeasonController::class, 'index'])->name('seasons');
    Route::get('/seasons/add', [SeasonController::class, 'add'])->name('seasons.add');
    Route::post('/seasons/add_', [SeasonController::class, 'add_'])->name('seasons.add_');
    Route::get('/seasons/{id}', [SeasonController::class, 'detail'])->name('seasons.detail');
    Route::post('/seasons/{id}', [SeasonController::class, 'detail_'])->name('seasons.detail_');

    Route::get('/languages', [LanguageController::class, 'index'])->name('languages');
    Route::get('/languages/add', [LanguageController::class, 'add'])->name('languages.add');
    Route::post('/languages/add', [LanguageController::class, 'add_'])->name('languages.add_');
    Route::get('/languages/{code}/notifications', [LanguageController::class, 'notifications'])->name('languages.notifications');
    Route::post('/languages/{code}/notifications', [LanguageController::class, 'notifications_'])->name('languages.notifications_');
    Route::get('/languages/{code}', [LanguageController::class, 'detail'])->name('languages.detail');
    Route::post('/languages/{code}', [LanguageController::class, 'detail_'])->name('languages.detail_');
    Route::post('/languages/delete/{code}', [LanguageController::class, 'delete'])->name('languages.delete_');

    Route::post('/charts/dashboard-stats', [ChartController::class, 'dashboardStats']);
});
