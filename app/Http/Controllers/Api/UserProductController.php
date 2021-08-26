<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @group UserProduct endpoints
 */
class UserProductController extends Controller
{
    /**
     * Show the user create product history
     */
    public function product()
    {
        $product = Product::with('users')->where('user_id', auth()->user()->id)->get();

        return ProductResource::collection($product);
    }
}
