let mix = require('laravel-mix');
const fs = require('fs')
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
mix.copy('node_modules/ckeditor', 'public/js/ckeditor');
mix.copy('resources/assets/js/admin/ckeditor_config.js', 'public/js/ckeditor/config.js');
mix.copy('node_modules/amcharts3', 'public/js/amcharts');

// 後台
mix.js('resources/assets/js/admin/app.js', 'public/js/admin')
   .sass('resources/assets/scss/admin/app.scss', 'public/css/admin').version();

mix.js('resources/assets/js/admin/date_helper.js', 'public/js/date_helper.js').version();

//前台
mix.js('resources/assets/js/pages/app.js', 'public/js/pages')
   .sass('resources/assets/scss/pages/app.scss', 'public/css/pages').version();

mix.webpackConfig({ node: { fs: 'empty' ,child_process: 'empty'}})
