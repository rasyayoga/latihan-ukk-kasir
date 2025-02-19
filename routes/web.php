<?php

use App\Http\Controllers\DetailSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalessController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return redirect()->route('dashboard');
});


Route::get('/dashboard',[DetailSalesController::class, 'index'])->name('dashboard');


Route::get('/product',[ProductsController::class, 'index'])->name('product');
Route::put('/product/{id}', [ProductsController::class, 'updateStock'])->name('product.stock');
Route::get('/product/create', [ProductsController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductsController::class, 'store'])->name('product.store');
Route::delete('/product/{id}', [ProductsController::class, 'destroy'])->name('product.delete');
Route::get('/product/edit/{id}', [ProductsController::class, 'edit'])->name('product.edit');
Route::put('/product/edit/{id}', [ProductsController::class, 'update'])->name('product.update');

Route::get('/user',[UserController::class, 'index'])->name('user.list');
Route::get('/user/create',[UserController::class, 'create'])->name('user.create');
Route::post('/user/store',[UserController::class, 'store'])->name('user.store');
//contoh route adalah jika id tidak ditemukan/akses memakai text maka akan diarahkan ke route user.list
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->where('id', '[0-9]+')->name('user.edit');
Route::put('/user/update/{id}',[UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}',[UserController::class, 'destroy'])->name('user.delete');

Route::get('/sales',[SalessController::class, 'index'])->name('sales');
Route::get('/sales/create',[SalessController::class, 'create'])->name('sales.create');
Route::post('/sales/create/post',[SalessController::class, 'store'])->name('sales.store');
Route::get('/sales/create/post',[SalessController::class, 'post'])->name('sales.post');
