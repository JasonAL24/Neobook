<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (!in_array(Route::currentRouteName(), ['login', 'register'])) {
                // Retrieve the authenticated member if not on 'login' or 'register' routes
                $member = auth()->user()->member;
                $view->with('member', $member);
            }
        });
    }
}
