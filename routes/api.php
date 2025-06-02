<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/craftedProducts', [ProductController::class, 'craftedProducts']);


Route::middleware('auth:sanctum')->group(function () {
    // USER SIDE
    Route::get('/add-to-cart/{id}', [ProductController::class,'addToCart']);
    Route::get('/cart-count', [ProductController::class,'cartCount']);
    // ADMIN ROUTES
    Route::middleware('roleChecker:admin')->prefix('admin')->group(function () {
        Route::post('/addProduct', [ProductController::class, 'create']);
    });
});

