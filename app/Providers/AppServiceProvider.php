<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;

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
        view()->composer('wl-admin.layouts.sidebar', function ($view) {
            $categories = Category::with('subcategories')->get();
            $view->with('categories', $categories);
        });
    }
}
