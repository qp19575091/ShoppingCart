<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'qty'];

    public function products()
    {
        return $this->hasMany(Cart::class);
    }

    public function show()
    {
        return Cart::where('user_id', auth()->user()->id)->get();
    }

    public function add(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
                'qty' => 1,
            ]);
        } else {
            $cart->qty += 1;
            $cart->save();
        }
        return response()->json(['qty' => $cart->qty]);
    }

    public function deleteByOne(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();

        if (!$cart) {
            return response()->json('No product in cart');
        }
        $cart->qty -= 1;
        $cart->save();
        if ($cart->qty === 0) {
            $cart->delete();
            return response()->json('No product in cart');
        }
        return response()->json(['qty' => $cart->qty]);
    }

    public function deleteProduct(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->get();
        //return $cart;
        if ($cart) {
            $cart->each->delete();
        }
        return response()->json(['message' => 'The Product is null']);
    }

    public function deleteAllCart()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        $cart->each->delete();
        return response()->json(['message' => 'Cart has been clear']);
    }

    public function isProductInCart(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->get();
        return $cart;
    }
}
