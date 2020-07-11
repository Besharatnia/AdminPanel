<?php

namespace Alirezab\AdminPanel;

use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/assets' => base_path('public/ap'),
            __DIR__ . '/views' => resource_path('views/ap'),
        ], 'ap');
    }

    public function register()
    {

    }
}
