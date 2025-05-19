<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryWebController;

Route::get('/', function () {
    return view('welcome');
});

// Wallet view
Route::get('/wallets', [WalletController::class, 'indexView'])->name('wallets.view');

// API-style resource routes (for AJAX or API)
Route::resource('categories', CategoryController::class);

// Web Blade CRUD routes
Route::prefix('web/categories')->name('web.categories.')->group(function () {
    Route::get('/', [CategoryWebController::class, 'index'])->name('index');
    Route::get('/create', [CategoryWebController::class, 'create'])->name('create');
    Route::post('/', [CategoryWebController::class, 'store'])->name('store');
    Route::get('/{category}/edit', [CategoryWebController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryWebController::class, 'update'])->name('update');
    Route::delete('/{category}', [CategoryWebController::class, 'destroy'])->name('destroy');
});
