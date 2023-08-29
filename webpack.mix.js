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

mix.react('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles(['resources/css/map.css'], 'public/css/common.css')
    .extract(['react', 'jquery', 'bootstrap']);

/*
 |--------------------------------------------------------------------------
 | Mix Asset Versioning / Cache Busting
 |--------------------------------------------------------------------------
 |
 | https://laravel.com/docs/7.x/mix#versioning-and-cache-busting
 | The version method will automatically append a unique hash to the
 | filenames of all compiled files, allowing for more convenient cache busting
 |
 */
 if (mix.inProduction())
    mix.version();