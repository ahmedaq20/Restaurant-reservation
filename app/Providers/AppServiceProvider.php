<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\View\Components\Layouts\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
    {
            Paginator::useBootstrap();
        // Blade::component('layouts.auth', Auth::class);
        // Blade::component('layouts.guest', \App\View\Components\GuestLayout::class);
    }
}