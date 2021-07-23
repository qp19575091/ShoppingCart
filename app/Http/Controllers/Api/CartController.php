<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;


/**
 * @group Cart endpoints
 */
class CartController extends Controller
{
    /**
     * Shows user cart
     * 
     * @authenticated
     * 
     * @urlParam product integer required The ID of the product. emxample: 1
     * 
     * @response 200 {
     *     "qty": 2,
     *     "products": {
     *         "name": "Dignissimos.",
     *         "price": "35.19",
     *         "quantity_left": 2
     *     },
     * }
     * 
     * @response 200 {
     *     "message": "No products in cart."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     */
    public function show(Cart $cart)
    {
        return $cart->show();
    }

    /**
     * Add to cart
     * 
     * @authenticated
     * 
     * @urlParam product integer required The ID of the product. emxample: 1
     * 
     * @response 200 {
     *     "message": "The Product Laborum natus nam. has 1 in cart."
     * }
     * 
     * @response 200 {
     *     "message": "庫存不夠. Your cart already has 3."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=404 scenario="Not found" {
     *     "error": "Resource Not Found"
     * }
     */
    public function add(Cart $cart, Product $product)
    {
        return $cart->add($product);
    }
    /**
     * Delete one product quantity to cart
     * 
     * @authenticated
     * 
     * @urlParam product integer required The ID of the product. emxample: 1
     * 
     * @response 200 {
     *     "message": "The Product Laborum natus nam. has 1 in cart."
     * }
     * 
     * @response 200 {
     *     "message": "Product Velit vitae debitis. Not in the cart."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     */
    public function deleteByOne(Cart $cart, Product $product)
    {
        return $cart->deleteByOne($product);
    }
    /**
     * Delete product from cart
     * 
     * @authenticated
     * 
     * @urlParam product integer required The ID of the product. emxample: 1
     * 
     * 
     * @response 200 {
     *      "message": "The Product has already clear."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     */
    public function deleteProduct(Cart $cart, Product $product)
    {
        return $cart->deleteProduct($product);
    }
    /**
     * Clear cart
     * 
     * @authenticated
     * 
     * 
     * @response 200 {
     *      "message": "Cart has been clear."
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     */
    public function deleteAllCart(Cart $cart)
    {
        return $cart->deleteAllCart();
    }
}
