<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;

Route::get('/',[ProductosController::class , 'index'])->name('InicioProductos');
Route::post('/guardarProductoNuevo' , [ProductosController::class , 'store'])->name('guardarProductoNuevo');
Route::post('/editarProducto' , [ProductosController::class , 'update'])->name('editarProducto');
Route::post('/getProductos' , [ProductosController::class, 'getProductos'])->name('getProductos');
Route::post('/obtenerDataProducto' , [ProductosController::class , 'obtenerDataProducto'])->name('obtenerDataProducto');
Route::post('/eliminar' , [ProductosController::class , 'destroy'])->name('eliminarProducto');
Route::get('/obtenerCSV' , [ProductosController::class , 'obtenerCSV'])->name('obtenerCSV');