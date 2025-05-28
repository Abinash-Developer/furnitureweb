<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllerWeb;
use App\Http\Controllers\AuthControllerWeb;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Product Routes
Route::get('/', [ProductControllerWeb::class,'fetch']);

Route::post('customer-login', [AuthControllerWeb::class,'login'])->name('customer-login.login');
Route::get('/add-to-cart', [ProductControllerWeb::class,'addToCart'])->middleware('roleChecker:customer');

Route::get('/shop', function () {
    return view('shop');
});
Route::get('/about-us', function () {
    return view('about');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/blog', function () {
    return view('blog');
});
Route::get('/contact-us', function () {
    return view('contact');
});
Route::get('/cart',[ProductControllerWeb::class,'fetchCartProducts']);
Route::get('/remove-cart-products',[ProductControllerWeb::class,'removeCartProduct']);
Route::get('/checkouts',function(){
    return view('checkout');
});


