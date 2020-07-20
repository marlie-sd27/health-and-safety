<?php

namespace App\Providers;

use App\Forms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

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
        // get all the forms to create links
        View::share('links', Forms::select('id', 'title')->get());


        // load user info with each view
        View::composer('*', function ($view)
        {
            if (session('error')) {
                $view->with('error', session('error'));
                $view->with('errorDetail', session('errorDetail'));
            }

            if(Auth::check())
            {
                View::share('admin', Auth::user()->isAdmin());
                View::share('userName', Auth::user()->name );
                View::share('userEmail', Auth::user()->email);
            }
        });
    }
}
