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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//user
Route::post('user-create', [Api\UserController::class, 'register']);
Route::post('login', [Api\UserController::class, 'login']);
Route::get('user', [Api\UserController::class, 'index']);

//product
Route::apiResource('/products',Api\ProductController::class);

//cart
Route::get('/cart', [Api\CartController::class, 'show']);
Route::post('/cart', [Api\CartController::class, 'add']);
Route::delete('/cart/{cart}', [Api\CartController::class, 'deleteByOne']);
Route::delete('/cart', [Api\CartController::class, 'deleteAll']);

//Order
Route::get('/order', [Api\OrderController::class, 'show']);
Route::post('/order', [Api\OrderController::class, 'store']);
