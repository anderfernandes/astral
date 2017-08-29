const { mix } = require('laravel-mix');

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

mix.scripts([
    'node_modules/simplemde/dist/simplemde.min.js'
], 'public/js/vendor.js');

mix.styles([
    'node_modules/simplemde/dist/simplemde.min.css'
], 'public/css/vendor.css');
