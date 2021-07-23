<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Auth;
use App\Http\Resources\ProductResource;
use DB;
use Illuminate\Support\Facades\Redis;

/**
 * @group Products endpoints
 */
class ProductController extends Controller
{
    /**
     * Get the products
     * 
     * @urlParam page integer required The number of the product page. emxample: ?page = 1
     * 
     * @response 200{
     *     {
     *          "name": "Officiis quia.",
     *          "price": "40.68",
     *          "quantity_left": 3,
     *          "users": {
     *              "name": "Prof. Adrien Adams",
     *              "email": "Demo@Demo.com"
     *          }
     *     },  
     *     {
     *          "name": "Ad consequatur ut.",
     *          "price": "35.09",
     *          "quantity_left": 3
     *          "users": {
     *              "name": "Prof. Adrien Adams",
     *              "email": "Demo@Demo.com"
     *          }
     *     }
     * }
     */
    public function index()
    {
        $product = Product::with('users')->simplepaginate(10);

        return response()->json(ProductResource::collection($product));
    }
 /**
     * Create product
     * 
     * @authenticated
     * 
     * @bodyParam name string required The name of the products. Example: Explicabo dolorem
     * @bodyParam price float required The price of the products. Example: 35.35
     * @bodyParam quantity_left integer required The quantity_left of the products. Example: 3
     * 
     * @response 200 {
     *     "name": "Explicabo dolorem.",
     *     "price": "35.35",
     *     "quantity_left": 3
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=403 scenario="Forbidden" {
     *     "error": "Forbidden"
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     * 
     */
    public function store(ProductRequest $request, Product $product)
    {
        $product = Auth::User()->products()->create($request->validated());

        return response()->json(new ProductResource($product));
    }
    /**
     * Show product
     * 
     * @authenticated
     * 
     * @response 200 {
     *     "name": "Explicabo dolorem.",
     *     "price": "35.35",
     *     "quantity_left": 3
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     *
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     * 
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product));
    }
    /**
     * Update product
     * 
     * @authenticated
     * 
     * @bodyParam name string required The name of the products. Example: Explicabo dolorem
     * @bodyParam price float required The price of the products. Example: 35.35
     * @bodyParam quantity_left integer required The quantity_left of the products. Example: 3
     * 
     * @response 200 {
     *     "name": "Explicabo dolorem.",
     *     "price": "35.35",
     *     "quantity_left": 3
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=403 scenario="Forbidden" {
     *     "error": "Forbidden"
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     * 
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = Product::where('id', $product->id)->where('user_id', auth()->user()->id)->first();

        // Has resource in database but Forbidden for the user
        if (!$product) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $product = $product->update($request->validated());

        return response()->json(new ProductResource($product));
    }

    /**
     * Delete product
     * 
     * @authenticated
     * 
     * @response 204{
     *     
     * }
     * 
     * @response status=401 scenario="Unauthenticated" {
     *     "error": "Unauthenticated."
     * }
     * 
     * @response status=403 scenario="Forbidden" {
     *     "error": "Forbidden"
     * }
     * 
     * @response status=404 scenario="Not Found" {
     *     "error": "Resource Not Found"
     * }
     * 
     */
    public function destroy(Product $product)
    {
        $product = Product::with('user')->where('user_id', auth()->user()->id)->where('id', $product->id)->first();

        // Has resource in database but Forbidden for the user 
        if (!$product) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }
        $product->delete();

        return response()->noContent();
    }
}
