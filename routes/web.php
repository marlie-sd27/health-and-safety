<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/signin', 'LoginController@signin')->name('signin');
Route::get('/callback', 'LoginController@callback');
Route::get('/signout', 'LoginController@signout')->name('signout');


// Admin routes
Route::middleware(['auth','isadmin'])->group(function ()
{
    Route::resource('forms', 'FormsController')->except('show');
    Route::post('toggle-live', 'FormsController@toggleLive');

    Route::get('report', 'ReportsController@report')->name('report');
    Route::get('report/overdue', 'ReportsController@overdue')->name('report.overdue');
    Route::get('report/upcoming', 'ReportsController@upcoming')->name('report.upcoming');

    Route::get('admins', 'AdminController@index')->name('admins');
    Route::post('admins', 'AdminController@store')->name('admins.store');
    Route::delete('admins/{admin}', 'AdminController@destroy')->name('admins.destroy');

});


// authenticate (ensure user is logged in)
Route::middleware('auth')->group(function () {

    // reporting submissions requires admin or principal designation
    Route::middleware('admin_or_principal')->group(function() {
        Route::get('report', 'ReportsController@report')->name('report');
        Route::get('export', 'ReportsController@export')->name('export');
    });


    Route::resource('submissions', 'SubmissionsController');
    Route::get('forms/{form}', 'FormsController@show')->name('forms.show');

    // Profile
    Route:: get('/profile', 'UserController@profile')->name('profile');

    // Dashboard
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    // Calendar
    Route::get('/calendar', 'CalendarController@calendar')->name('calendar');
    Route::get('/events', 'EventsController@index');
});


