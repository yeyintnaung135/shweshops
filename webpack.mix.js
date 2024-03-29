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

mix.js('resources/js/app.js', 'public/js/app.js')
    .js('resources/js/tz.js', 'public/js/tz.js');

mix.js('resources/js/backend.js', 'public/js');
// mix.webpackConfig({
//     resolve: {
//         alias: {
//             'vue$': 'vue/dist/vue.runtime.common.js'
//         }
//     }
// });
