<?php

namespace Alirezab\AdminPanel;

use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/assets' => public_path('vendor/AdminPanel'),
        ], 'public');
        $this->loadViewsFrom(__DIR__ . '/views', 'AdminPanel');

    }

    public function register()
    {

    }
}
