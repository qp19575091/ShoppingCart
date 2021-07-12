<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Facade;
use App\Models\Cart;

class CartController extends Controller
{
    public function show(Cart $cart)
    {
        
    }

    public function add()
    {
        
    }

    public function deleteByOne(Cart $cart)
    {
        
    }

    public function deleteAll(Cart $cart)
    {
        
        $cart->delete();
        
    }
}
