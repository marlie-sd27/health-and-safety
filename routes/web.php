<?php

use Illuminate\Support\Facades\Route;

// Authentication
Route::get('/', 'HomeController@welcome');
Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');
