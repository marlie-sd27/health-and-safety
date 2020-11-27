<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/signin', 'LoginController@signin')->name('signin');
Route::get('/callback', 'LoginController@callback');
Route::get('/signout', 'LoginController@signout')->name('signout');

Route::get('/groups', 'UserController@groups');


// Admin routes
Route::middleware(['auth','isadmin'])->group(function ()
{
    //forms
    Route::resource('forms', 'FormsController')->except('show');
    Route::post('toggle-live', 'FormsController@toggleLive');

    //submission reporting


    // manage users
    Route::get('users', 'UserController@index')->name('users');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');

    // manage admins
    Route::get('admins', 'AdminController@index')->name('admins');
    Route::post('admins', 'AdminController@store')->name('admins.store');
    Route::delete('admins/{admin}', 'AdminController@destroy')->name('admins.destroy');

    // managing users with report access (who aren't principals)
    Route::get('reporters', 'ReportingPrivilegesController@index')->name('reporters');
    Route::post('reporters', 'ReportingPrivilegesController@store')->name('reporters.store');
    Route::delete('reporter/{user}', 'ReportingPrivilegesController@destroy')->name('reporters.destroy');

    // events (deadlines)
    Route::delete('events/{event}', 'DeadlinesController@destroy')->name('events.destroy');
    Route::get('events', 'DeadlinesController@index')->name('events');
    Route::get('events/upcoming', 'DeadlinesController@upcoming')->name('events.upcoming');

    // training
    Route::post('training', 'TrainingController@store')->name('training.store');
    Route::get('training/create', 'TrainingController@create')->name('training.create');
    Route::delete('training/{training}', 'TrainingController@destroy')->name('training.destroy');
    Route::put('training/{training}', 'TrainingController@update')->name('training.update');
    Route::get('training/{training}/edit', 'TrainingController@edit')->name('training.edit');

    // managing courses list
    Route::get('courses', 'CoursesController@index')->name('courses');
    Route::post('course', 'CoursesController@store')->name('courses.store');
    Route::delete('course/{course}', 'CoursesController@destroy')->name('courses.destroy');

    // managing groups list
    Route::get('groups', 'GroupsController@index')->name('groups');
    Route::post('group', 'GroupsController@store')->name('groups.store');
    Route::delete('group/{group}', 'GroupsController@destroy')->name('groups.destroy');

    // managing sites list
    Route::get('sites', 'SitesController@index')->name('sites');
    Route::post('site', 'SitesController@store')->name('sites.store');
    Route::delete('site/{site}', 'SitesController@destroy')->name('sites.destroy');

    // managing assignments
    Route::get('assignments', 'AssignmentsController@index')->name('assignments');
    Route::post('assignments', 'AssignmentsController@store')->name('assignments.store');
    Route::put('assignment/{assignment}', 'AssignmentsController@update')->name('assignments.update');
    Route::delete('assignment/{assignment}', 'AssignmentsController@destroy')->name('assignments.destroy');
    Route::get('assignments/overdue', 'AssignmentsController@overdue')->name('assignments.overdue');

});


// authenticate (ensure user is logged in)
Route::middleware('auth')->group(function () {

    // reporting submissions/training requires admin or principal designation
    Route::middleware('reporting_access')->group(function() {
        Route::get('submissions/export', 'SubmissionsController@export')->name('submissions.export');
        Route::get('training/report', 'TrainingController@report')->name('training.report');

        // report on deadlines
        Route::get('report-deadlines', 'ReportOnDeadlinesController@index')->name('report-deadlines');
        Route::get('report-deadlines/export', 'ReportOnDeadlinesController@export')->name('report-deadlines.export');
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
    Route::get('/events/ajax', 'DeadlinesController@ajax')->name('events.ajax');
});


