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
//Route::middleware('auth')->group(function() {

    //Forms
    Route::get('/hschecklist', 'FormsController@hschecklist');
    Route::resource('forms', 'FormsController');

    // Profile
    Route:: get('/profile', 'UserController@profile')->name('profile');
//});

