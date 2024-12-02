<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::put('transactions/{id}/submit', [AdminController::class, 'confirm'])->name('admin.transactions.submit');


});

// User Routes
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/product/{id}', [UserController::class, 'show'])->name('user.product');
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
    Route::post('/cart/{id}/add', [UserController::class, 'addToCart'])->name('user.cart.add');
    Route::put('/cart/update/{id}', [UserController::class, 'updateCart'])->name('user.cart.update');
    Route::delete('/cart/remove/{id}', [UserController::class, 'removeFromCart'])->name('user.cart.remove');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    Route::post('/checkout', [UserController::class, 'checkout'])->name('user.cart.checkout');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/cart/checkout', [UserController::class, 'checkout'])->name('user.cart.checkout');
    Route::get('/transactions', [UserController::class, 'transactions'])->name('user.transactions');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
