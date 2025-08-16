<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register your custom CSS
        FilamentAsset::register([
            Css::make('custom-dashboard', public_path('css/filament.css')),
        ]);

        // You can also register JS similarly if needed
        // FilamentAsset::register([
        //     Js::make('custom-dashboard-js', public_path('js/filament.js')),
        // ]);
    }
}
