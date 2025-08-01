<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/servicios/json', [App\Http\Controllers\ServicioController::class, 'json'])->name('servicios.json');
});

Auth::routes();

Route::get('productos/import', [App\Http\Controllers\ProductoController::class, 'showImportForm'])->name('productos.import.form');
Route::post('productos/import', [App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import');

Route::get('/cuentas/{id}/saldo', function ($id) {
    \Log::info("Consultando saldo de cuenta: $id");

    $cuenta = \App\Models\CuentaBancaria::findOrFail($id);
    return response()->json([
        'nombre' => $cuenta->nombre,
        'saldo'  => $cuenta->saldo,
    ]);
})->middleware('auth');




// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta para el escaneo de QR
Route::get('/scan', function () {
    return view('scan.scan_qr');
})->middleware('auth')->name('scan.qr');

// Rutas para Alertas
Route::prefix('alerta')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AlertaController::class, 'index'])->name('alerta.index');
    Route::get('/{alerta}', [App\Http\Controllers\AlertaController::class, 'show'])->middleware('can:ver alertas')->name('alerta.show');
    Route::get('/{alerta}/edit', [App\Http\Controllers\AlertaController::class, 'edit'])->middleware('can:editar alertas')->name('alerta.edit');
    Route::put('/{alerta}', [App\Http\Controllers\AlertaController::class, 'update'])->middleware('can:editar alertas')->name('alerta.update');
    Route::delete('/{alerta}', [App\Http\Controllers\AlertaController::class, 'destroy'])->middleware('can:eliminar alertas')->name('alerta.destroy');
});


// Rutas para Almacen
Route::prefix('almacen')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AlmacenController::class, 'index'])->name('almacen.index');
    Route::get('/create', [App\Http\Controllers\AlmacenController::class, 'create'])->middleware('can:crear almacenes')->name('almacen.create');
    Route::post('/', [App\Http\Controllers\AlmacenController::class, 'store'])->middleware('can:crear almacenes')->name('almacen.store');
    Route::get('/{almacen}', [App\Http\Controllers\AlmacenController::class, 'show'])->middleware('can:ver almacenes')->name('almacen.show');
    Route::get('/{almacen}/edit', [App\Http\Controllers\AlmacenController::class, 'edit'])->middleware('can:editar almacenes')->name('almacen.edit');
    Route::put('/{almacen}', [App\Http\Controllers\AlmacenController::class, 'update'])->middleware('can:editar almacenes')->name('almacen.update');
    Route::delete('/{almacen}', [App\Http\Controllers\AlmacenController::class, 'destroy'])->middleware('can:eliminar almacenes')->name('almacen.destroy');
});

// Rutas para Servicios
Route::prefix('servicios')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/create', [App\Http\Controllers\ServicioController::class, 'create'])->middleware('can:crear servicios')->name('servicios.create');
    Route::post('/', [App\Http\Controllers\ServicioController::class, 'store'])->middleware('can:crear servicios')->name('servicios.store');
    Route::get('/{servicio}', [App\Http\Controllers\ServicioController::class, 'show'])->middleware('can:ver servicios')->name('servicios.show');
    Route::get('/{servicio}/edit', [App\Http\Controllers\ServicioController::class, 'edit'])->middleware('can:editar servicios')->name('servicios.edit');
    Route::put('/{servicio}', [App\Http\Controllers\ServicioController::class, 'update'])->middleware('can:editar servicios')->name('servicios.update');
    Route::delete('/{servicio}', [App\Http\Controllers\ServicioController::class, 'destroy'])->middleware('can:eliminar servicios')->name('servicios.destroy');
});

// Rutas para Bajas
Route::prefix('bajas')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\BajaController::class, 'index'])->name('bajas.index');
    Route::get('/create', [App\Http\Controllers\BajaController::class, 'create'])->middleware('can:crear bajas')->name('bajas.create');
    Route::post('/', [App\Http\Controllers\BajaController::class, 'store'])->middleware('can:crear bajas')->name('bajas.store');
    Route::get('/{baja}', [App\Http\Controllers\BajaController::class, 'show'])->middleware('can:ver bajas')->name('bajas.show');
    Route::get('/{baja}/edit', [App\Http\Controllers\BajaController::class, 'edit'])->middleware('can:editar bajas')->name('bajas.edit');
    Route::put('/{baja}', [App\Http\Controllers\BajaController::class, 'update'])->middleware('can:editar bajas')->name('bajas.update');
    Route::delete('/{baja}', [App\Http\Controllers\BajaController::class, 'destroy'])->middleware('can:eliminar bajas')->name('bajas.destroy');
});

// Rutas para Categorias
Route::prefix('categorias')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/create', [App\Http\Controllers\CategoriaController::class, 'create'])->middleware('can:crear categorias')->name('categorias.create');
    Route::post('/', [App\Http\Controllers\CategoriaController::class, 'store'])->middleware('can:crear categorias')->name('categorias.store');
    Route::get('/{categoria}', [App\Http\Controllers\CategoriaController::class, 'show'])->middleware('can:ver categorias')->name('categorias.show');
    Route::get('/{categoria}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->middleware('can:editar categorias')->name('categorias.edit');
    Route::put('/{categoria}', [App\Http\Controllers\CategoriaController::class, 'update'])->middleware('can:editar categorias')->name('categorias.update');
    Route::delete('/{categoria}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->middleware('can:eliminar categorias')->name('categorias.destroy');
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
    Route::get('/{id}/qr', [App\Http\Controllers\ProductoController::class, 'downloadQR'])->name('productos.qr');
});

// Rutas para Proveedores
Route::prefix('proveedores')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/create', [App\Http\Controllers\ProveedorController::class, 'create'])->middleware('can:crear proveedores')->name('proveedores.create');
    Route::post('/', [App\Http\Controllers\ProveedorController::class, 'store'])->middleware('can:crear proveedores')->name('proveedores.store');
    Route::get('/{proveedor}', [App\Http\Controllers\ProveedorController::class, 'show'])->middleware('can:ver proveedores')->name('proveedores.show');
    Route::get('/{proveedor}/edit', [App\Http\Controllers\ProveedorController::class, 'edit'])->middleware('can:editar proveedores')->name('proveedores.edit');
    Route::put('/{proveedor}', [App\Http\Controllers\ProveedorController::class, 'update'])->middleware('can:editar proveedores')->name('proveedores.update');
    Route::delete('/{proveedor}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->middleware('can:eliminar proveedores')->name('proveedores.destroy');
});

// Rutas para Requisiciones
Route::prefix('requisiciones')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\RequisicionesController::class, 'index'])->middleware('can:ver requisiciones')->name('requisiciones.index');
    Route::get('/create', [App\Http\Controllers\RequisicionesController::class, 'create'])->middleware('can:crear requisiciones')->name('requisiciones.create');
    Route::post('/', [App\Http\Controllers\RequisicionesController::class, 'store'])->middleware('can:crear requisiciones')->name('requisiciones.store');
    Route::get('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'show'])->middleware('can:ver requisiciones')->name('requisiciones.show');
    Route::get('/{requisicion}/edit', [App\Http\Controllers\RequisicionesController::class, 'edit'])->middleware('can:editar requisiciones')->name('requisiciones.edit');
    Route::put('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'update'])->middleware('can:editar requisiciones')->name('requisiciones.update');
    Route::delete('/{requisicion}', [App\Http\Controllers\RequisicionesController::class, 'destroy'])->middleware('can:eliminar requisiciones')->name('requisiciones.destroy');
    Route::get('/partidas-por-capitulo/{capitulo}', [App\Http\Controllers\RequisicionesController::class, 'porCapitulo'])->name('requisiciones.partidasPorCapitulo');
    
});


// Configuraciones generales
Route::prefix('admin/settings')->middleware('can:ver configuraciones')->group(function () {
    // Configuración general
    Route::get('/', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

    // Cuentas
    Route::prefix('cuentas')->middleware('can:ver cuentas')->group(function () {
        Route::get('/', [App\Http\Controllers\CuentaBancariaController::class, 'index'])->name('cuentas.index');
        Route::get('/create', [App\Http\Controllers\CuentaBancariaController::class, 'create'])->middleware('can:crear cuentas')->name('cuentas.create');
        Route::post('/', [App\Http\Controllers\CuentaBancariaController::class, 'store'])->middleware('can:crear cuentas')->name('cuentas.store');
        Route::get('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'show'])->middleware('can:ver cuentas')->name('cuentas.show');
        Route::get('/{cuenta}/edit', [App\Http\Controllers\CuentaBancariaController::class, 'edit'])->middleware('can:editar cuentas')->name('cuentas.edit');
        Route::put('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'update'])->middleware('can:editar cuentas')->name('cuentas.update');
        Route::delete('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'destroy'])->middleware('can:eliminar cuentas')->name('cuentas.destroy');
    });

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

    // Actividad
    Route::prefix('actividad')->middleware('can:ver actividades')->group(function () {
        Route::get('/', [App\Http\Controllers\ActividadController::class, 'index'])->name('actividades.index');
        Route::get('/actividad', [App\Http\Controllers\ActividadController::class, 'create'])->middleware('can:crear actividades')->name('actividades.create');
        Route::post('/', [App\Http\Controllers\ActividadController::class, 'store'])->middleware('can:crear actividades')->name('actividades.store');
        Route::get('/{actividad}', [App\Http\Controllers\ActividadController::class, 'show'])->middleware('can:ver actividades')->name('actividades.show');
        Route::get('/{actividad}/edit', [App\Http\Controllers\ActividadController::class, 'edit'])->middleware('can:editar actividades')->name('actividades.edit');
        Route::put('/{actividad}', [App\Http\Controllers\ActividadController::class, 'update'])->middleware('can:editar actividades')->name('actividades.update');
        Route::delete('/{actividad}', [App\Http\Controllers\ActividadController::class, 'destroy'])->middleware('can:eliminar actividades')->name('actividades.destroy');
    });
});

Route::get('/prueba-404', function () {
    return response()->view('errors.404', [], 404);
});

