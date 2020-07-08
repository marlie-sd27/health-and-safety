<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome')->name('dashboard');
Route::get('/signin', 'AuthController@signin')->name('signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout')->name('signout');

// Calendar Routes
Route::get('/calendar', 'CalendarController@calendar');


// make sure authenticated
Route::middleware('auth')->group(function() {

    //Resources
    Route::resource('forms', 'FormsController');
    Route::resource('submissions', 'SubmissionsController');

    // Profile
    Route:: get('/profile', 'UserController@profile')->name('profile');
});

// Admin Access Only View
Route::get('unauthorized', 'Controller@unauthorized')->name('unauthorized');
