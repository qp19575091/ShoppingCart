<?php

use App\Http\Controllers\Api;
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

Route::middleware('auth:api')->group(function () {
    
    //user logout
    Route::post('/logout', [Api\UserController::class, 'logout']);
    //get auth user information
    Route::apiResource('users', Api\UserController::class)->only('index');



    //cart
    Route::get('/cart', [Api\CartController::class, 'show']);
    Route::post('/cart/products/{product}', [Api\CartController::class, 'add']);
    Route::delete('/cart/products/{product}', [Api\CartController::class, 'deleteByOne']);
    Route::delete('/cart/{id}', [Api\CartController::class, 'deleteProduct']);
    Route::delete('/cart', [Api\CartController::class, 'deleteAllCart']);

    //Order
    Route::get('/order', [Api\OrderController::class, 'checkout']);
    Route::post('/order', [Api\OrderController::class, 'store']);

    //UserOrder
    Route::get('/users.orders',[Api\UserOrderController::class, 'order']);

    //UserProduct
    Route::get('/users.products',[Api\UserProductController::class, 'product']);
});


//product
Route::apiResource('/products', Api\ProductController::class);
//user register
Route::post('register', [Api\UserController::class, 'register']);
//user login
Route::post('login', [Api\UserController::class, 'login']);
