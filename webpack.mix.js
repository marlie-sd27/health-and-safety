const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
    'resources/js/app.js',
], 'public/js/app.js');

mix.js([
    'resources/js/calendar.js'
], 'public/js/calendar.js');

mix.js([
    'resources/js/autolinker.js'
], 'public/js/autolinker.js');

mix.styles(
    [
        'resources/css/app.css',
        'resources/css/datepicker.css'
    ], 'public/css/app.css');
