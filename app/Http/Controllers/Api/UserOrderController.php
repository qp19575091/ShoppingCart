<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    // Show the user order history
    public function order()
    {
        $order = Order::where('user_id',  auth()->user()->id)->get();

        return $order;
    }
}
