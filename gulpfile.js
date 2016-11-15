const elixir = require('laravel-elixir');
var gulp = require('gulp');
var uglify = require("gulp-uglify");//压缩js
var minifyCss = require("gulp-minify-css");//压缩css
var rename = require('gulp-rename');//重命名
var autoprefixer = require('gulp-autoprefixer');

// require('laravel-elixir-vue');

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
gulp.task('min-css', function () {
    gulp.src('public/css/app.css') // 要压缩的css文件
        .pipe(minifyCss()) //压缩css
        .pipe(rename({suffix: '.min'}))//添加min后缀
        .pipe(gulp.dest('public/css'));
    gulp.src('public/css/home.css') // 要压缩的css文件
        .pipe(minifyCss()) //压缩css
        .pipe(rename({suffix: '.min'}))//添加min后缀
        .pipe(gulp.dest('public/css'));
});
gulp.task('min-js', function () {
    gulp.src('public/js/app.js') // 要压缩的js文件
        .pipe(uglify())  //使用uglify进行压缩,更多配置请参考：
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/js')); //压缩后的路径
});