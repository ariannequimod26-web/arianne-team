<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QueueController;

// Redirect home based on role
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->isStaff()) {
            return redirect()->route('admin.orders.index');
        }
        return redirect()->route('menu.index');
    }
    return redirect()->route('menu.index');
});

// TEMPORARY: Promote current user to admin (DELETE THIS AFTER USE)
Route::get('/make-me-admin', function () {
    if (auth()->check()) {
        auth()->user()->update(['role' => 'admin']);
        return 'You are now an admin! <a href="/admin/dashboard">Go to Admin Panel</a>';
    }
    return 'Please login first';
})->middleware('auth');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->isStaff()) {
        return redirect()->route('admin.orders.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu Routes
    Route::get('/menu', [MenuController::class, 'studentIndex'])->name('menu.index');
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

    // Order Routes
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Queue Routes (Public)
    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
    Route::get('/queue/stats', [QueueController::class, 'stats'])->name('queue.stats');

    // Staff Routes
    Route::middleware('staff')->group(function () {
        Route::post('/queue/{order}/assign', [QueueController::class, 'assignQueue'])->name('queue.assign');
        Route::post('/queue/{order}/status', [QueueController::class, 'updateStatus'])->name('queue.update-status');
        Route::post('/queue/{order}/pay', [QueueController::class, 'confirmPayment'])->name('queue.pay');
    });

    // Staff & Admin shared routes (staff can manage orders)
    Route::middleware('staff')->prefix('admin')->name('admin.')->group(function () {
        Route::get('orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    });

    // Admin-only Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('menu', MenuController::class);
    });
});

require __DIR__.'/auth.php';
