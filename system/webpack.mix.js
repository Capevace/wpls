let mix = require('laravel-mix');
let path = require('path');

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

mix.setPublicPath('./storage/assets');
mix.options({ imgLoaderOptions: { enabled: false } })
    .js('resources/assets/js/index.js', 'js')
   .sass('resources/assets/sass/index.scss', 'css');
