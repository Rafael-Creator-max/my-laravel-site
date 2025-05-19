<?php
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('wallets', WalletController::class)->names([
    'index' => 'api.wallets.index',
    'store' => 'api.wallets.store',
    'show' => 'api.wallets.show',
    'update' => 'api.wallets.update',
    'destroy' => 'api.wallets.destroy',
]);

Route::apiResource('transactions', TransactionController::class)->names([
    'index' => 'api.transactions.index',
    'store' => 'api.transactions.store',
    'show' => 'api.transactions.show',
    'update' => 'api.transactions.update',
    'destroy' => 'api.transactions.destroy',
]);
Route::apiResource('categories', CategoryController::class)->names([
    'index' => 'api.categories.index',
    'store' => 'api.categories.store',
    'show' => 'api.categories.show',
    'update' => 'api.categories.update',
    'destroy' => 'api.categories.destroy',
]);