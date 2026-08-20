<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog');
Route::get('/parfum/{perfume}', [CatalogController::class, 'show'])->name('perfume.show');
Route::get('/lang/{locale}', [CatalogController::class, 'switchLanguage'])->name('lang.switch');

Route::post('/commande', [OrderController::class, 'store'])->name('order.store');

// Admin auth
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Forgot password
Route::get('/admin/forgot-password', [AdminController::class, 'showForgotPassword'])->name('admin.forgot.password');
Route::post('/admin/forgot-password', [AdminController::class, 'sendResetCode'])->name('admin.forgot.send');
Route::get('/admin/reset-password', [AdminController::class, 'showResetPassword'])->name('admin.reset.password');
Route::post('/admin/reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset.submit');

// Admin dashboard & profile & settings
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

// Orders
Route::post('/admin/commandes/{order}/statut', [AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
Route::delete('/admin/commandes/{order}', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');

// Admin perfumes
Route::post('/admin/parfums', [AdminController::class, 'storePerfume'])->name('admin.perfume.store');
Route::get('/admin/parfums/{perfume}/edit', [AdminController::class, 'editPerfume'])->name('admin.perfume.edit');
Route::post('/admin/parfums/{perfume}', [AdminController::class, 'updatePerfume'])->name('admin.perfume.update');
Route::delete('/admin/parfums/{perfume}', [AdminController::class, 'deletePerfume'])->name('admin.perfume.delete');
