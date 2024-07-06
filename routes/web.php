<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);
route::get('admin/home', [HomeController::class, 'home'])->middleware(['auth', 'admin']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('admin', AdminController::class)->middleware(['auth', 'admin']);


//Product
Route::middleware('auth')->group(function () {
    Route::get('product', [ProductController::class, 'index'])->name('product.index');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');
    Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/{id}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::get('product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});




require __DIR__ . '/auth.php';
