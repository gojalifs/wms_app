<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IntakeOrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OutgoingOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $totalMaterials  = \App\Models\Material::count();
    $lowStockCount   = \App\Models\Inventory::whereRaw('quantity <= (SELECT min_stock FROM materials WHERE materials.id = inventories.material_id)')->count();
    $recentIntakes   = \App\Models\IntakeOrder::with('user')->latest()->limit(5)->get();
    $recentOutgoings = \App\Models\OutgoingOrder::with('user')->latest()->limit(5)->get();
    $intakeThisMonth = \App\Models\IntakeOrder::whereMonth('received_at', now()->month)
                        ->whereYear('received_at', now()->year)->count();
    $outgoingThisMonth = \App\Models\OutgoingOrder::whereMonth('issued_at', now()->month)
                        ->whereYear('issued_at', now()->year)->count();

    return view('dashboard', compact(
        'totalMaterials', 'lowStockCount',
        'recentIntakes', 'recentOutgoings',
        'intakeThisMonth', 'outgoingThisMonth'
    ));
})->middleware(['auth', 'verified', 'force.password.change'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Change password — NOT behind force.password.change so the form is always reachable
    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change.show');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.change.update');

    Route::middleware('force.password.change')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Materials — all authenticated users can view; only admin can create/edit/delete
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::middleware('role:admin')->group(function () {
            Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
            Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
            Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
            Route::patch('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        });
        Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

        // Categories — admin only
        Route::middleware('role:admin')->group(function () {
            Route::resource('categories', CategoryController::class)->except(['show']);
        });

        // Inventory — read-only, all authenticated users
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/{material}', [InventoryController::class, 'show'])->name('inventory.show');

        // Intake Orders
        Route::get('/intake', [IntakeOrderController::class, 'index'])->name('intake.index');
        Route::get('/intake/create', [IntakeOrderController::class, 'create'])->name('intake.create');
        Route::post('/intake', [IntakeOrderController::class, 'store'])->name('intake.store');
        Route::get('/intake/{intake}', [IntakeOrderController::class, 'show'])->name('intake.show');

        // Outgoing Orders (internal production use)
        Route::get('/outgoing', [OutgoingOrderController::class, 'index'])->name('outgoing.index');
        Route::get('/outgoing/create', [OutgoingOrderController::class, 'create'])->name('outgoing.create');
        Route::post('/outgoing', [OutgoingOrderController::class, 'store'])->name('outgoing.store');
        Route::get('/outgoing/{outgoing}', [OutgoingOrderController::class, 'show'])->name('outgoing.show');

        // Reports — admin only
        Route::middleware('role:admin')->group(function () {
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/intake', [ReportController::class, 'exportIntake'])->name('reports.intake');
            Route::get('/reports/outgoing', [ReportController::class, 'exportOutgoing'])->name('reports.outgoing');
            Route::get('/reports/inventory', [ReportController::class, 'exportInventory'])->name('reports.inventory');
        });

        // User management — admin only
        Route::middleware('role:admin')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

require __DIR__ . '/auth.php';
