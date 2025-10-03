<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



class AppServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Force MySQL session to Baghdad (+03:00)
        DB::statement("SET time_zone = '+03:00'");


        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role() == 1;
        });

        Blade::if('manager', function () {
            return auth()->check() && auth()->user()->role() == 2;
        });

        Blade::if('kitchen', function () {
            return auth()->check() && auth()->user()->role() == 3;
        });

        Blade::if('waiter', function () {
            return auth()->check() && auth()->user()->role() == 4;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
