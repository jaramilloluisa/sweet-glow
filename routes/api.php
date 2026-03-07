<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImagenesController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    // nombre de la ruta/ controlador/ metodo / alias /
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::apiResource('roles', App\Http\Controllers\RolesController::class);

Route::apiResource('users', App\Http\Controllers\UsuariosController::class);

Route::apiResource('categories', App\Http\Controllers\CategoriasController::class);

Route::apiResource('brands', App\Http\Controllers\MarcasController::class);

Route::apiResource('product_references', App\Http\Controllers\ReferenciaProductosController::class);

Route::apiResource('gift_guide', App\Http\Controllers\GuiaRegalosController::class);

Route::apiResource('products', App\Http\Controllers\ProductosController::class);

Route::apiResource('images', App\Http\Controllers\ImagenesController::class);

Route::apiResource('premios', App\Http\Controllers\PremioController::class);

Route::apiResource('premiados', App\Http\Controllers\PremiadosController::class);

Route::apiResource('gift_cards', App\Http\Controllers\TarjetasRegaloController::class);

Route::apiResource('order_invoice', App\Http\Controllers\FacturaPedidosController::class);

Route::apiResource('carts', App\Http\Controllers\CarritosController::class);

Route::apiResource('gift_registrations', App\Http\Controllers\InscripcionesRegaloController::class);