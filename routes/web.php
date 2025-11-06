<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/login', [AuthController::class, 'index'])->name('admin.login');
Route::post('admin/login-user', [AuthController::class, 'login'])->name('admin.login.user');

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function(){

    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('category/data', [CategoryController::class, 'getData'])->name('admin.category.data');
    Route::get('category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');

    Route::get('color', [ColorController::class, 'index'])->name('admin.color');
    Route::get('color/data', [ColorController::class, 'getData'])->name('admin.color.data');
    Route::get('color/create', [ColorController::class, 'create'])->name('admin.color.create');
    Route::post('color/store', [ColorController::class, 'store'])->name('admin.color.store');
    Route::get('color/edit/{id}', [ColorController::class, 'edit'])->name('admin.color.edit');
    Route::post('color/update/{id}', [ColorController::class, 'update'])->name('admin.color.update');
    Route::get('color/delete/{id}', [ColorController::class, 'delete'])->name('admin.color.delete');

    Route::get('products', [ProductsController::class, 'index'])->name('admin.products');
    Route::get('admin/products/data', [ProductsController::class, 'getData'])->name('admin.products.data');
    Route::get('products/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::post('products/store', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::get('products/edit/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::post('products/update/{id}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::get('products/delete/{id}', [ProductsController::class, 'delete'])->name('admin.products.delete');

});
