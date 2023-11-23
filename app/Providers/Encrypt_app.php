<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class Encrypt_app extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . 'Helpers/Encrypt_app.php';
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
