<?php

namespace Alirezab\AdminPanel;

use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        $this->publishes([
//            __DIR__.'/assets' => public_path('vendor/AdminPanel'),
//        ], 'public');


        $this->loadViewsFrom(__DIR__ . '/views', 'ap');

        $this->publishes([
//            __DIR__ . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'quickadmin.php'                                                  => config_path('quickadmin.php'),
            __DIR__ . '/assets/plugins' => base_path('public/quickadmin'),
        ], 'ap');

//        $this->publishes([
//            __DIR__.'/views' => resource_path('views/vendor/AdminPanel'),
//        ]);
    }

    public function register()
    {

    }
}
