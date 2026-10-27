<?php

use App\Http\Controllers\Inventory as I;
use Illuminate\Support\Facades\Route;

/**
 * IT Inventory (simple). Every route is permission-gated on the server (inv.* in config/itsm.php).
 * Loaded from routes/web.php; independent of the ticket routes.
 */
Route::middleware('auth')->prefix('inventory')->name('inv.')->group(function () {
    Route::get('/', [I\DashboardController::class, 'index'])->middleware('can:inv.view')->name('dashboard');

    // Equipment & stock
    Route::get('equipment', [I\EquipmentController::class, 'index'])->middleware('can:inv.view')->name('equipment.index');
    Route::get('equipment/create', [I\EquipmentController::class, 'create'])->middleware('can:inv.update')->name('equipment.create');
    Route::post('equipment', [I\EquipmentController::class, 'store'])->middleware('can:inv.update')->name('equipment.store');
    Route::get('equipment/{equipment}/edit', [I\EquipmentController::class, 'edit'])->middleware('can:inv.update')->name('equipment.edit');
    Route::put('equipment/{equipment}', [I\EquipmentController::class, 'update'])->middleware('can:inv.update')->name('equipment.update');

    // Asset types and sub categories
    Route::get('setup/{kind?}', [I\SetupController::class, 'index'])->middleware('can:inv.view')->name('setup');
    Route::post('setup/{kind}', [I\SetupController::class, 'store'])->middleware('can:inv.update')->name('setup.store');
    Route::put('setup/{kind}/{id}', [I\SetupController::class, 'update'])->middleware('can:inv.update')->name('setup.update');

    // Receive Item (new stock from a supplier, or items returned by an employee / department)
    Route::get('receives', [I\ReceiveController::class, 'index'])->middleware('can:inv.view')->name('receives');
    Route::get('receives/{entry}/pdf', [I\ReceiveController::class, 'pdf'])->middleware('can:inv.view')->name('receives.pdf');
    Route::get('receives/{entry}', [I\ReceiveController::class, 'show'])->middleware('can:inv.view')->where('entry', '[A-Z]{2,3}-[0-9]+')->name('receives.show');
    Route::get('receive', [I\ReceiveController::class, 'create'])->middleware('can:inv.create')->name('receive');
    Route::post('receive', [I\ReceiveController::class, 'store'])->middleware('can:inv.create')->name('receive.store');

    // Allocation and return
    Route::get('allocations', [I\AllocationController::class, 'index'])->middleware('can:inv.view')->name('allocations.index');
    Route::get('allocations/create', [I\AllocationController::class, 'create'])->middleware('can:inv.create')->name('allocations.create');
    Route::post('allocations', [I\AllocationController::class, 'store'])->middleware('can:inv.create')->name('allocations.store');
    Route::get('allocations/records', [I\AllocationController::class, 'entries'])->middleware('can:inv.view')->name('allocations.entries');
    Route::get('allocations/{entry}/pdf', [I\AllocationController::class, 'pdf'])->name('allocations.pdf');
    Route::get('allocations/{entry}', [I\AllocationController::class, 'show'])->where('entry', '[A-Z]{2,3}-[0-9]+')->name('allocations.show');
    Route::get('my-items', [I\AllocationController::class, 'mine'])->name('mine');

    // Records
    Route::get('records', [I\RecordController::class, 'index'])->middleware('can:inv.view')->name('records');
    Route::get('records/{movement}', [I\RecordController::class, 'show'])->middleware('can:inv.view')->whereNumber('movement')->name('records.show');
});
