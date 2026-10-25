<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\LookupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/assignment-board', [DashboardController::class, 'board'])->middleware('can:dashboard.officer')->name('board.index');

    // Own account
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->middleware('throttle:20,1')->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
    Route::get('/avatars/{user}', [ProfileController::class, 'avatar'])->name('avatar.show');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('throttle:10,1')->name('profile.password.update');

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/my-requests', [TicketController::class, 'mine'])->middleware('can:ticket.work')->name('tickets.mine');
    Route::get('/my-tasks', [TicketController::class, 'tasks'])->middleware('can:ticket.work')->name('tasks.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->middleware('can:ticket.create')->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->middleware('can:ticket.create')->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/history-pdf', [TicketController::class, 'historyPdf'])->name('tickets.history.pdf');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{ticket}/transition', [TicketController::class, 'transition'])->name('tickets.transition');
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::post('/tickets/{ticket}/team', [TicketController::class, 'team'])->name('tickets.team');
    Route::post('/tickets/{ticket}/work', [TicketController::class, 'work'])->name('tickets.work');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'comment'])->name('tickets.comment');
    Route::post('/tickets/{ticket}/notes', [TicketController::class, 'note'])->name('tickets.note');
    Route::post('/tickets/{ticket}/attachments', [TicketController::class, 'upload'])->name('tickets.upload');
    Route::get('/attachments/{attachment}', [TicketController::class, 'download'])->name('attachments.download');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::get('/notifications/{id}', [NotificationController::class, 'read'])->name('notifications.read');

    // Keep-alive ping sent by the page while the user is active (see layout script)
    Route::post('/session/keepalive', fn () => response()->noContent())->name('session.keepalive');

    // Attendance: all IT employees (Management) / own record (IT employees)
    Route::get('/attendance', [AttendanceController::class, 'index'])->middleware('can:attendance.view')->name('attendance.index');
    Route::get('/attendance/pdf', [AttendanceController::class, 'pdf'])->middleware('can:attendance.view')->name('attendance.pdf');
    Route::get('/my-attendance', [AttendanceController::class, 'mine'])->middleware('can:attendance.own')->name('attendance.mine');

    // Reports
    Route::middleware('can:report.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/csv', [ReportController::class, 'csv'])->name('reports.csv');
    });

    // Administration
    Route::prefix('admin')->name('admin.')->group(function () {
        // Users: Read / Add / Update
        Route::get('users', [UserController::class, 'index'])->middleware('can:user.view')->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->middleware('can:user.create')->name('users.create');
        Route::post('users', [UserController::class, 'store'])->middleware('can:user.create')->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->middleware('can:user.update')->name('users.edit');
        Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->middleware('can:user.update')->name('users.update');

        // Roles: Read / Add / Update / Delete
        Route::get('roles', [RoleController::class, 'index'])->middleware('can:role.view')->name('roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->middleware('can:role.create')->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->middleware('can:role.create')->name('roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware('can:role.view')->name('roles.edit');
        Route::match(['put', 'patch'], 'roles/{role}', [RoleController::class, 'update'])->middleware('can:role.update')->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->middleware('can:role.delete')->name('roles.destroy');

        // System settings
        Route::get('settings', [SettingController::class, 'index'])->middleware('can:settings.view')->name('settings');
        Route::put('settings', [SettingController::class, 'update'])->middleware('can:settings.update')->name('settings.update');

        // Configuration lists: Read / Add / Update
        Route::get('lookups/{type}', [LookupController::class, 'index'])->middleware('can:lookup.view')->name('lookups');
        Route::post('lookups/{type}', [LookupController::class, 'store'])->middleware('can:lookup.create')->name('lookups.store');
        Route::put('lookups/{type}/{id}', [LookupController::class, 'update'])->middleware('can:lookup.update')->name('lookups.update');
        Route::middleware('can:audit.view')->group(function () {
            Route::get('audit', [AuditController::class, 'logs'])->name('audit');
            Route::get('logins', [AuditController::class, 'logins'])->name('logins');
        });
    });
});
