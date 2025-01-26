<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta para el escaneo de QR
Route::get('/scan', function () {
    return view('scan.scan_qr');
})->middleware('auth')->name('scan.qr');


// Rutas para Proveedores
Route::prefix('proveedores')->middleware('auth')->group(function () {
    Route::post('/store', [ProveedorController::class, 'store'])->name('proveedores.store');
});

// Rutas para Productos
Route::prefix('productos')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
    Route::get('/create', [App\Http\Controllers\ProductoController::class, 'create'])->middleware('can:crear productos')->name('productos.create');
    Route::post('/', [App\Http\Controllers\ProductoController::class, 'store'])->middleware('can:crear productos')->name('productos.store');
    Route::get('/{producto}', [App\Http\Controllers\ProductoController::class, 'show'])->middleware('can:ver productos')->name('productos.show');
    Route::get('/{producto}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->middleware('can:editar productos')->name('productos.edit');
    Route::put('/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->middleware('can:editar productos')->name('productos.update');
    Route::delete('/{producto}', [App\Http\Controllers\ProductoController::class, 'destroy'])->middleware('can:eliminar productos')->name('productos.destroy');
});



// Rutas para Cuentas Bancarias
Route::prefix('cuentas')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CuentaBancariaController::class, 'index'])->name('cuentas.index');
    Route::get('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'show'])->name('cuentas.show');
});

// Rutas para Requisiciones
Route::prefix('requisiciones')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CuentaBancariaController::class, 'index'])->name('requisiciones.index');
    Route::get('/{cuenta}/index', [App\Http\Controllers\RequisicionesController::class, 'indexByCuenta'])->name('requisiciones.cuenta.index');
    Route::get('/create', [App\Http\Controllers\RequisicionesController::class, 'create'])->middleware('can:crear requisiciones')->name('requisiciones.create');
    Route::post('/', [App\Http\Controllers\RequisicionesController::class, 'store'])->middleware('can:crear requisiciones')->name('requisiciones.store');
    Route::get('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'show'])->middleware('can:ver requisiciones')->name('requisiciones.show');
    Route::get('/{requisicion}/edit', [App\Http\Controllers\RequisicionesController::class, 'edit'])->middleware('can:editar requisiciones')->name('requisiciones.edit');
    Route::put('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'update'])->middleware('can:editar requisiciones')->name('requisiciones.update');
    Route::delete('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'destroy'])->middleware('can:eliminar requisiciones')->name('requisiciones.destroy');
    Route::get('/global', [App\Http\Controllers\RequisicionesController::class, 'index'])->middleware('can:ver requisiciones')->name('requisiciones.global.index');
});



// Configuraciones generales
Route::prefix('admin/settings')->middleware('can:ver configuraciones')->group(function () {
    // Configuración general
    Route::get('/', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

    // Usuarios
    Route::prefix('users')->middleware('can:ver usuarios')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->middleware('can:crear usuarios')->name('users.create');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:crear usuarios')->name('users.store');
        Route::get('/{user}', [App\Http\Controllers\UserController::class, 'show'])->middleware('can:ver usuarios')->name('users.show');
        Route::get('/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->middleware('can:editar usuarios')->name('users.edit');
        Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:editar usuarios')->name('users.update');
        Route::delete('/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:eliminar usuarios')->name('users.destroy');
    });


    // Roles
    Route::prefix('roles')->middleware('can:ver roles')->group(function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [App\Http\Controllers\RoleController::class, 'create'])->middleware('can:crear roles')->name('roles.create');
        Route::post('/', [App\Http\Controllers\RoleController::class, 'store'])->middleware('can:crear roles')->name('roles.store');
        Route::get('/{role}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
        Route::get('/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('can:editar roles')->name('roles.edit');
        Route::put('/{role}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('can:editar roles')->name('roles.update');
        Route::delete('/{role}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:eliminar roles')->name('roles.destroy');
        Route::get('/{role}/permissions', [App\Http\Controllers\RoleController::class, 'permissions'])->middleware('can:editar roles')->name('roles.permissions');
        Route::post('/{role}/permissions', [App\Http\Controllers\RoleController::class, 'assignPermissions'])->middleware('can:editar roles')->name('roles.assignPermissions');
    });
});

Route::get('/prueba-404', function () {
    return response()->view('errors.404', [], 404);
});

