<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
use App\Service\CartService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Wrapping data
         */
        JsonResource::withoutWrapping();
    }
}
