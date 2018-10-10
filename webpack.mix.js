let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

// Vendor stuff, non-js

mix.scripts([
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/jquery-address/src/jquery.address.js',
  'node_modules/moment/min/moment.min.js',
  'node_modules/simplemde/dist/simplemde.min.js',
  'node_modules/flatpickr/dist/flatpickr.min.js',
  'node_modules/fullcalendar/dist/fullcalendar.min.js',
  'node_modules/marked/marked.min.js',
  'node_modules/chart.js/dist/Chart.min.js',
  ], 'public/js/vendor.js');

mix.styles([
  'node_modules/simplemde/dist/simplemde.min.css',
  'node_modules/flatpickr/dist/flatpickr.min.css',
  'node_modules/fullcalendar/dist/fullcalendar.min.css'
  ], 'public/css/vendor.css');
