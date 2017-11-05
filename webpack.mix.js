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
    .js('resources/assets/js/admin.js', 'public/js')
    .extract(['vue','axios'])
    .version();

mix.scripts(['resources/assets/js/soj.js'], 'public/js/soj.js').version();

mix.scripts(['resources/assets/js/ace.js',
    'resources/assets/js/ext_language_tools.js'],'public/js/ace.js').version();

mix.sass('resources/assets/sass/soj.scss', 'public/css')
    .version();
