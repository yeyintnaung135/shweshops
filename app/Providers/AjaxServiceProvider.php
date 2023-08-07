<?php

namespace App\Providers;


use App\Ajax;
use Illuminate\Support\ServiceProvider;

class AjaxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('photos',function(){
            return new Ajax;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
