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
                $user = auth()->user();

                if ($user && $user->member) {
                    $member = $user->member;
                    $view->with('member', $member);
                } else {
                    return redirect()->route('login')->with('alert', 'Please log in to access this page.');
                }
            }
        });
    }
}
