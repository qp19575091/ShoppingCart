<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Facade;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function show(Cart $cart)
    {
        return $cart->show();
    }

    public function add(Cart $cart, Product $product)
    {
        return $cart->add($product);
    }

    public function deleteByOne(Cart $cart, Product $product)
    {
        return $cart->deleteByOne($product);
    }

    public function deleteProduct(Cart $cart, Product $product)
    {
        return $cart->deleteProduct($product);
    }

    public function deleteAllCart(Cart $cart)
    {
        return $cart->deleteAllCart();
    }
}
