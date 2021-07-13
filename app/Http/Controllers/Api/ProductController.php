<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Auth;

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
        $product = Product::simplepaginate();
        return response()->json($product);
    }

    public function store(ProductRequest $request)
    {
        $product = Auth::user()->products()->create([
            $request->all()
        ]);
        dd($product);
        // $product = Auth::user()->products()->create([
        //     $request->validated()
        // ]);
        return $product;
    }

    public function show(Product $product)
    {
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = Product::where('id', $product->id)->where('user_id', auth()->user()->id)->first();

        if ($product) {
            $product->update([
                $request->validated()
            ]);
        }
        return $product;
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
        $product = Product::where('user_id', auth()->user()->id)->where('id', $product->id)->first();
        return $product;
        if (!$product) {
            return response()->json(['Not Found Product']);
        }
        $product->delete();
        return response()->noContent();
    }
}
