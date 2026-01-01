<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    public function boot()
    {
        // Share instagram posts only with layout
        View::composer('frontend.layout', function ($view) {
            $instagram_posts = \App\Models\Backend\InstagramPost::active()
                                    ->ordered()
                                    ->take(12)
                                    ->get();
            $view->with('instagram_posts', $instagram_posts);
        });
    }
}
