<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('register', [UserController::class, 'register'])->name('user.register');
    Route::get('user/details', [UserController::class, 'details'])->name('user.details');

    // Produtos
    Route::get('products', [ProductController::class, 'index'])->name('product.index');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');
    Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.show');
    Route::put('product/{slug}', [ProductController::class, 'update'])->name('product.update');
    Route::patch('product/{slug}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('product/{slug}', [ProductController::class, 'destroy'])->name('product.destroy');
});
