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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/sass/bootstrap/css/bootstrap.min.css', 'public/bootstrap/css')
    .js('resources/sass/bootstrap/js/bootstrap.min.js', 'public/bootstrap/js')
    .copy('resources/sass/styles.css', 'public/css')
    .copy('resources/sass/untitled.css', 'public/css');

mix.disableNotifications();
