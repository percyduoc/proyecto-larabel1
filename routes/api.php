<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TipoPrestacionController;
use App\Http\Controllers\PrestacionController;
use App\Http\Controllers\PrecioController;
use App\Http\Controllers\TipoVentaController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\DetalleCuentaController;


Route::apiResource('tipo-ventas', TipoVentaController::class);


Route::apiResource('precios', PrecioController::class);
Route::apiResource('prestaciones', PrestacionController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('sucursales', SucursalController::class);
Route::apiResource('tipo-prestaciones', TipoPrestacionController::class);
Route::apiResource('cuentas', CuentaController::class);
Route::apiResource('detalles', DetalleCuentaController::class);


// Define la ruta para obtener el total de una cuenta específica
Route::get('cuentas/{id}/total', [CuentaController::class, 'getTotalCuenta']);













