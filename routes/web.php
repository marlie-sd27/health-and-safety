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
    //forms
    Route::resource('forms', 'FormsController')->except('show');
    Route::post('toggle-live', 'FormsController@toggleLive');

    //submission reporting
    Route::get('submissions/overdue', 'SubmissionsReportsController@overdue')->name('submissions.overdue');
    Route::get('submissions/upcoming', 'SubmissionsReportsController@upcoming')->name('submissions.upcoming');

    // manage admins
    Route::get('admins', 'AdminController@index')->name('admins');
    Route::post('admins', 'AdminController@store')->name('admins.store');
    Route::delete('admins/{admin}', 'AdminController@destroy')->name('admins.destroy');

    // events
    Route::delete('events/{event}', 'EventsController@destroy')->name('events.destroy');
    Route::get('events', 'EventsController@index')->name('events');

    // training
    Route::post('training', 'TrainingController@store')->name('training.store');
    Route::get('training/create', 'TrainingController@create')->name('training.create');
    Route::delete('training/{training}', 'TrainingController@destroy')->name('training.destroy');
    Route::put('training/{training}', 'TrainingController@update')->name('training.update');
    Route::get('training/{training}/edit', 'TrainingController@edit')->name('training.edit');

    // managing courses list
    Route::get('courses', 'CoursesController@index')->name('courses');
    Route::post('course', 'CoursesController@store')->name('course.store');
    Route::put('course/{course}', 'CoursesController@update')->name('course.update');
    Route::delete('course/{course}', 'CoursesController@destroy')->name('course.destroy');

    // managing sites list
    Route::get('sites', 'sitesController@index')->name('sites');
    Route::post('site', 'SitesController@store')->name('site.store');
    Route::put('site/{site}', 'SitesController@update')->name('site.update');
    Route::delete('site/{site}', 'SitesController@destroy')->name('site.destroy');

});


// authenticate (ensure user is logged in)
Route::middleware('auth')->group(function () {

    // reporting submissions/training requires admin or principal designation
    Route::middleware('admin_or_principal')->group(function() {
        Route::get('submissions/report', 'SubmissionsReportsController@report')->name('submissions.report');
        Route::get('submissions/export', 'SubmissionsReportsController@export')->name('submissions.export');
        Route::get('training/report', 'TrainingController@report')->name('training.report');
    });

    Route::get('training', 'TrainingController@index')->name('training.index');
    Route::get('training/{training}', 'TrainingController@show')->name('training.show');

    Route::resource('submissions', 'SubmissionsController');
    Route::post('file', 'FileController')->name('file.download');
    Route::get('forms/{form}', 'FormsController@show')->name('forms.show');

    // Profile
    Route:: get('/profile', 'UserController@profile')->name('profile');

    // Dashboard
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    // Calendar
    Route::get('/calendar', 'CalendarController@calendar')->name('calendar');
    Route::get('/events/ajax', 'EventsController@ajax')->name('events.ajax');
});


