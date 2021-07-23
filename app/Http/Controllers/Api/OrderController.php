<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use DB;

/**
 * @group Order endpoints
 */
class OrderController extends Controller
{
    public $totalPrice;

     /**
     * Clear cart
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "message": "Your cart is empty. Try to add products to cart"
     * }
     * 
     * @response 200 {
     *      "message": "Product Dignissimos. Not found in stock"
     * }
     * 
     * @response 200 {
     *      "message": "Success."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     * 
     * @response status=500 scenario="Server Error" {
     *     "error": "Try again or contact us"
     * }
     */
    public function checkout()
    {
        // Find product in user cart
        $cart = Cart::with('products')->where('user_id', auth()->user()->id)->get();

        // Check the cart is empty or not
        if($cart->isEmpty()){
            return response()->json(['message' => 'Your cart is empty. Try to add products to cart']);
        }

        $products = Product::select('id', 'quantity_left')
            ->whereIn('id', $cart->pluck('product_id'))
            ->pluck('quantity_left', 'id');

        // Check the product quantity_left
        foreach ($cart as $cartProduct) {
            if (!isset($products[$cartProduct->product_id])
                || $products[$cartProduct->product_id] < $cartProduct->qty) {
                return response()->json(['message' => 'Product ' . $cartProduct->products->name . ' not found in stock']);
            }
        }
        // Checkout transaction
        try {
            DB::transaction(function () use ($cart){
                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'total_price' => 0
                ]);
                
                foreach ($cart as $cartProduct) {
                    $order->products()->attach($cartProduct->product_id, [
                        'qty' => $cartProduct->qty,
                        'price' => $cartProduct->products->price
                    ]);
                    $order->increment('total_price', $cartProduct->qty * $cartProduct->products->price);
                    Product::find($cartProduct->products->id)->decrement('quantity_left', $cartProduct->qty);
                }
                
                Cart::where('user_id', auth()->user()->id)->delete();
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Try again or contact us'], 500);
        }
        return response()->json(['message' => 'Success']);
    }
}
