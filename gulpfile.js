const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
var js = [
    'resources/assets/js/jquery.js',
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/hightlight.js',
    'resources/assets/js/marked.js',
    /*'resources/assets/js/nprogress.js',
     'resources/assets/js/pjax.js',
     'jquery-scrolltofixed-min.js',*/
    'autosize.min.js',
    'imgLiquid-min.js',
    'codemirror-4.inline-attachment.js',
    'resources/assets/js/app.js',
];
elixir(function (mix) {
    mix
        .sass('app.scss')
        .sass('home.scss', './public/css/home.css')
        .scripts(js, './public/js/app.js')
        .version(['css/app.css', 'css/home.css', 'js/app.js']);
});
