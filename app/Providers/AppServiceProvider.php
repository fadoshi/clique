<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;
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
        Route::bind('user', function (string $value) {
            return Tenant::where('slug', $value)->firstOrFail();
        });
    }
}
