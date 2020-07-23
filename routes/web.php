<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/signin', 'LoginController@signin')->name('signin');
Route::get('/callback', 'LoginController@callback');
Route::get('/signout', 'LoginController@signout')->name('signout');
Route::get('/calendar', 'CalendarController@calendar')->name('calendar');


// Admin routes (prefix=admin and name prefix=admin)
Route::middleware(['auth','isadmin'])->group(function ()
{

    Route::resource('forms', 'FormsController')->except('show');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('submissions', 'AdminSubmissionController@index')->name('submissions.index');
    });
});


// authenticate (ensure user is logged in)
Route::middleware('auth')->group(function () {

    Route::resource('submissions', 'SubmissionsController');
    Route::get('forms/{form}', 'FormsController@show')->name('forms.show');

    // Profile
    Route:: get('/profile', 'UserController@profile')->name('profile');

    // Dashboard
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
});
