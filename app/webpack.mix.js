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
require('laravel-mix-tailwind');

// for PurgeCSS
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css').sourceMaps()
    .copyDirectory('node_modules/popper.js/dist/umd/popper.js.map', 'public/js')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .tailwind()
    .purgeCss({
        enabled: mix.inProduction(),
        folders: ['src', 'templates'],
        extensions: ['twig', 'html', 'js', 'php', 'vue'],
    })
    .setPublicPath('public');
