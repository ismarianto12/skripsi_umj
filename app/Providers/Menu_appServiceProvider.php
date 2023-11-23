<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class Menu_appServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . 'Helpers/Menu_app.php';
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
