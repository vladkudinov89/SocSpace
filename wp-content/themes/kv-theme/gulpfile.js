let babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    gulp = require('gulp'),
    minify = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    clean = require('gulp-clean');

let paths = {
    mycss:['dist/css/AdminLTE.css'],
    myscript:['dist/js/main.js']
};

gulp.task('js', () => {
    gulp.src([
        'bower_components/jquery/dist/jquery.min.js',
        /*'bower_components/jquery.sticky/jquery.sticky.js',*/
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/jquery-ui/jquery-ui.min.js',
        'bower_components/scrollspy/build/jquery.scrollspy.js',
        'bower_components/magnific-popup/dist/jquery.magnific-popup.min.js',
        'dist/js/main.js',
        'dist/js/adminlte.js'
    ])
        .pipe(babel({presets: ['es2015']})) //
        .pipe(concat('common.js'))
        .pipe(rename('common.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js/'));
});

gulp.task('css', () => {
    gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css',
        'bower_components/magnific-popup/dist/magnific-popup.css',
        'bower_components/fontawesome/css/font-awesome.min.css',
        'dist/css/bootstrap.fd.css',
        'dist/css/skins/skin-blue.min.css',
        'dist/css/AdminLTE.css'
    ])
        .pipe(concat('styles.css'))
        .pipe(minify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('dist/css/'));
});

/*gulp.task('watcher',function(){
    gulp.watch(paths.mycss, ['css']);
    gulp.watch(paths.myscript, ['js']);
});*/

/*gulp.task('default', ['js', 'css' ,'watcher'] , ()=>{
    console.log("Я работаю");
});*/

gulp.task('default', ['js', 'css'], function () {
});

/*
 gulp.task('default', ['js']);*/
