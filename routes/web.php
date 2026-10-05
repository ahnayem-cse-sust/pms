<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\LookupController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:20,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->middleware('can:ticket.create')->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->middleware('can:ticket.create')->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/transition', [TicketController::class, 'transition'])->name('tickets.transition');
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'comment'])->name('tickets.comment');
    Route::post('/tickets/{ticket}/notes', [TicketController::class, 'note'])->name('tickets.note');
    Route::post('/tickets/{ticket}/attachments', [TicketController::class, 'upload'])->name('tickets.upload');
    Route::get('/attachments/{attachment}', [TicketController::class, 'download'])->name('attachments.download');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::get('/notifications/{id}', [NotificationController::class, 'read'])->name('notifications.read');

    // Reports
    Route::middleware('can:report.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/csv', [ReportController::class, 'csv'])->name('reports.csv');
    });

    // Administration
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('can:user.manage')->group(function () {
            Route::resource('users', UserController::class)->except(['show', 'destroy']);
            Route::get('settings', [SettingController::class, 'index'])->name('settings');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        });
        Route::middleware('can:lookup.manage')->group(function () {
            Route::get('lookups/{type}', [LookupController::class, 'index'])->name('lookups');
            Route::post('lookups/{type}', [LookupController::class, 'store'])->name('lookups.store');
            Route::put('lookups/{type}/{id}', [LookupController::class, 'update'])->name('lookups.update');
        });
        Route::middleware('can:audit.view')->group(function () {
            Route::get('audit', [AuditController::class, 'logs'])->name('audit');
            Route::get('logins', [AuditController::class, 'logins'])->name('logins');
        });
    });
});
