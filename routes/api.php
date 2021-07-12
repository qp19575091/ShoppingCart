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
    //product
    Route::apiResource('/products', Api\ProductController::class);
    //user logout
    Route::post('/logout', [Api\UserController::class, 'logout']);
    //get auth user information
    Route::apiResource('users', Api\UserController::class)->only('index');



    //cart
    Route::get('/cart', [Api\CartController::class, 'show']);
    Route::post('/cart', [Api\CartController::class, 'add']);
    Route::delete('/cart/{cart}', [Api\CartController::class, 'deleteByOne']);
    Route::delete('/cart', [Api\CartController::class, 'deleteAll']);

    //Order
    Route::get('/order', [Api\OrderController::class, 'show']);
    Route::post('/order', [Api\OrderController::class, 'store']);
});


//user register
Route::post('register', [Api\UserController::class, 'register']);
//user login
Route::post('login', [Api\UserController::class, 'login']);
