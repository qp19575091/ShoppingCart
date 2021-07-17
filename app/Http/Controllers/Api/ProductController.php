<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Auth;
use App\Http\Resources\ProductResource;
use DB;

class ProductController extends Controller
{
    /**
     * Get the 15 products in one page
     * 
     * @response 200{
     *     "current_page": 1,
     *     "data": [
     *         {    
     *              "id": 1,
     *              "user_id": 1,
     *              "name": "Officiis quia.",
     *              "price": "40.68",
     *              "created_at": "2021-07-11T11:48:28.000000Z",
     *              "updated_at": "2021-07-11T11:48:28.000000Z",
     *              "quantity_left": 3
     *         },  
     *         {
     *              "id": 2,
     *              "user_id": 1,
     *              "name": "Ad consequatur ut.",
     *              "price": "35.09",
     *              "created_at": "2021-07-11T11:48:28.000000Z",
     *              "updated_at": "2021-07-11T11:48:28.000000Z",
     *              "quantity_left": 3
     *         },
     *     ]
     * }
     */
    public function index()
    {
        DB::enableQueryLog(); // Enable query log

        $product = Product::with('users')->simplepaginate();

        dd(DB::getQueryLog()); // Show results of log
        

        return response()->json(ProductResource::collection($product));
    }

    public function store(ProductRequest $request, Product $product)
    {
        $product = Auth::User()->products()->create($request->validated());

        return response()->json(new ProductResource($product));
    }

    public function show(Product $product)
    {
        // Has resource in database but Forbidden for the user
        if (!$product) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }
        return response()->json(new ProductResource($product));
    }

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
     * @response 204{
     *     
     * }
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
