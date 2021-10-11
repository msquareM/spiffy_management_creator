<?php

namespace Trioangle\SpiffyAutogenerate;

use Illuminate\Support\ServiceProvider;

class AutoGenerateManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {   
        // register our controller
        $this->app->make('Trioangle\SpiffyAutogenerate\AutoGenerateManagementController');
        $this->loadViewsFrom(__DIR__.'/views', 'autogenerate');

        include __DIR__.'/routes.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        
    }
}
