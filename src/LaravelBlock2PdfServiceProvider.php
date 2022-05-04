<?php

namespace GMJ\LaravelBlock2Pdf;

use GMJ\LaravelBlock2Pdf\View\Components\Frontend;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelBlock2PdfServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php", 'LaravelBlock2Pdf');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'LaravelBlock2Pdf');

        Blade::component("LaravelBlock2Pdf", Frontend::class);

        $this->publishes([
            __DIR__ . '/database/seeders' => database_path('seeders'),
        ], 'GMJ\LaravelBlock2Pdf');
    }


    public function register()
    {
    }
}
