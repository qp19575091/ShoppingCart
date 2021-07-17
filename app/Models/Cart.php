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
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function show()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();

        if ($cart->isEmpty()) {
            return response('No products in cart.');
        }
        return $cart;
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
        } elseif ($cart->qty < $product->quantity_left) {
            $cart->qty += 1;
            $cart->save();
        } else {
            return response()->json(['message' => '庫存不夠. ' . 'Your cart already has ' . $cart->qty]);
        }
        return response()->json(['message' => 'The Product ' . $product->name . ' has ' . $cart->qty . ' in cart']);
    }

    public function deleteByOne(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();

        if (!$cart) {
            return response()->json('No product in cart.');
        }
        $cart->qty -= 1;
        $cart->save();
        if ($cart->qty === 0) {
            $cart->delete();
            return response()->json('No product in cart.');
        }
        return response()->json(['message' => 'The Product ' . $product->name . ' has ' . $cart->qty . ' in cart.']);
    }

    public function deleteProduct(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->get();
        //return $cart;
        if ($cart) {
            $cart->each->delete();
        }
        return response()->json(['message' => 'The Product has already clear.']);
    }

    public function deleteAllCart()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        $cart->each->delete();
        return response()->json(['message' => 'Cart has been clear']);
    }

    public function isProductInCart(Product $product)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->exist();
        return $cart;
    }
}
