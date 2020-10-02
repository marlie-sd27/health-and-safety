<?php

namespace App\Providers;

use App\Forms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        DB::connection()->disableQueryLog();
        // load user info with each view
        View::composer('*', function ($view) {
            // get all the forms to create links
            View::share('links', Forms::where('live', true)
                ->select('id', 'title')
                ->orderBy('id', 'asc')
                ->get());


            if (session('error')) {
                $view->with('error', session('error'));
                $view->with('errorDetail', session('errorDetail'));
            }

            if (Auth::check()) {
                View::share('admin', Auth::user()->isAdmin());
                View::share('report_access', Auth::user()->isReporter());
                View::share('principal', Auth::user()->isPrincipal());
                View::share('userName', Auth::user()->name);
                View::share('userEmail', Auth::user()->email);
            }
        });
    }
}
