<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $menuAdministrador = file_get_contents(base_path('resources/json/menuAdmin.json'));
        $menuAdministradorData = json_decode($menuAdministrador);
        // Share all menuData to all the views
        View::share('menuData', [$menuAdministradorData]);
    }
}
