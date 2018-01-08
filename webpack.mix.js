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

mix.webpackConfig({
    output: {
        publicPath: "/",
        //chunkFilename: 'js/[name].[chunkhash].js'
    },
});

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js')
    .extract(['vue','axios','vue-router'])
    .version();

mix.scripts(['resources/assets/js/soj.js'], 'public/js/soj.js').version();

mix.sass('resources/assets/sass/soj.scss', 'public/css')
    .version();
