<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome');
Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');

// Calendar Routes
Route::get('/calendar', 'CalendarController@calendar');

// Profile
Route:: get('/profile', 'UserController@profile');

//Forms
Route::get('/hschecklist', 'FormsController@hschecklist');
