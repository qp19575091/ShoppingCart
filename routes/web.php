<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return 1;
});

Route::get('/test', function () {
    $orders = Order::with('products')->get();


    foreach ($orders as $order) {
        foreach ($order->products as $product) {
            echo  $product->pivot->qty;
        }
    }
    return;
    dd($order->products->pivot->qty);
    return '1' . $order->pivot;
});
