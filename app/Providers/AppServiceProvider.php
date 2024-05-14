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
            $user = auth()->user();
            if ($user && !in_array(Route::currentRouteName(), ['login', 'register'])) {
                $member = $user->member;
                if ($member){
                    $view->with('member', $member);
                } else{
                    return redirect()->route('login')->with('alert', 'Mohon login terlebih dahulu');
                }
            }
            return redirect()->route('login')->with('alert', 'Mohon login terlebih dahulu');
        });
    }
}
