<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Filament\Pages\ImageViewer;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
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
    //redireccion a imageViewer
    {   
    if (class_exists(Filament::class)) {
        Filament::registerViteTheme('resources/css/filament.css');
        Filament::registerPages([
            ImageViewer::class,
            ]);
           
        }
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en','fr','es']); // also accepts a closure
        });
        
    }
}
