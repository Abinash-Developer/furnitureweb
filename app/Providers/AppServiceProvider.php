<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AddToCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

       view()->composer('*', function ($view) {
        $count= '';
            if ( Auth::id()) {
                $count = AddToCart::where('user_id', Auth::id())->count();
            }

            $view->with('add_to_cart_count', $count);
        });
    }
}
