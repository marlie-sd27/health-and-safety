<?php

namespace App\Providers;

use App\Forms;
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

            if(session('userName'))
            {
                $view->with('admin', session('admin'));
                $view->with('userName', session('userName') );
                $view->with('userEmail', session('userEmail'));
            }
        });
    }
}
