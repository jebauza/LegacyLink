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
    .vue()
    .sass('resources/sass/app.scss', 'public/css');


/* mix.styles([
        'resources/vendor/css/fullcalendar.bundle.css',
        'resources/vendor/css/plugins.bundle.css',
        'resources/vendor/css/prismjs.bundle.css',
        'resources/vendor/css/style.bundle.css',
    ], 'public/css/template.css')
    .vue() //JQuery, Bootstrap, VueJS
    .scripts([
        'resources/vendor/js/plugins.bundle.js',
        'resources/vendor/js/prismjs.bundle.js',
        'resources/vendor/js/scripts.bundle.js',
        'resources/vendor/js/fullcalendar.bundle.js',
        'resources/vendor/js/widgets.js',
    ], 'public/js/template.js')
    .copy('resources/vendor/fonts', 'public/fonts'); */