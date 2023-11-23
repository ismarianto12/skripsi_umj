<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class Properti_appProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . 'Helpers/Properti_app.php';
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
