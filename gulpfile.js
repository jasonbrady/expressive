'use strict';

var cache = require('gulp-cached');
var del = require('del');
var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var minifyCss = require('gulp-clean-css');
var path = require('path');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');

//CSS Processing
gulp.task('clean-css', function() {
    return del('public/css', { force: true });
});

gulp.task('compile-sass', function() {
    return gulp.src('src/*/public/sass/**/*.scss', { base: './' })
        .pipe(cache('compile-sass'))
        .pipe(sass().on('error', sass.logError))
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^src\/([^\/]+\/)public\/sass/, '$1');
        }))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('copy-css', function() {
    return gulp.src('src/*/public/css/**/*.css', { base: './' })
        .pipe(cache('copy-css'))
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^src\/([^\/]+\/)public\/css/, '$1');
        }))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('minify-css', function() {
    return gulp.src(['public/css/**/*.css', '!public/css/**/*.min.css'], { base: './' })
        .pipe(cache('minify-css'))
        .pipe(minifyCss())
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^public\/css/, '');
        }))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('public/css'))
    ;
});
gulp.task('process-css', gulp.series(['compile-sass', 'copy-css'], 'minify-css'));

//JS Processing
gulp.task('clean-js', function() {
    return del('public/js', { force: true });
});

gulp.task('copy-js', function() {
    return gulp.src('src/*/public/js/**/*.js', { base: './' })
        .pipe(cache('copy-js'))
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^src\/([^\/]+\/)public\/js/, '$1');
        }))
        .pipe(gulp.dest('public/js/'));
});

gulp.task('minify-js', function() {
    return gulp.src(['public/js/**/*.js', '!public/js/**/*.min.js'], { base: './' })
        .pipe(cache('minify-js'))
        .pipe(uglify())
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^public\/js/, '');
        }))
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest('public/js'))
    ;
});
gulp.task('process-js', gulp.series('copy-js', 'minify-js'));

//Image Processing
gulp.task('clean-img', function() {
    return del('public/img', { force: true });
});

gulp.task('process-img', function() {
    return gulp.src('src/*/public/img/**/*.{gif,jpg,jpeg,png,svg}', { base: './' })
        .pipe(cache('process-img'))
        .pipe(imagemin())
        .pipe(rename(function (path) {
            path.dirname = path.dirname.replace(/^src\/([^\/]+\/)public\/img/, '$1');
        }))
        .pipe(gulp.dest('public/img'));
});

//Top Level Commands
gulp.task('default', gulp.parallel('process-js', 'process-css', 'process-img'));
gulp.task('clean', gulp.parallel('clean-js', 'clean-css', 'clean-img'));

gulp.task('watch', function() {
    gulp.watch(['src/*/public/sass/**/*.scss','src/*/public/css/**/*.css'], gulp.series('process-css'));
    gulp.watch('src/*/public/js/**/*.js', gulp.series('process-js'));
    gulp.watch('src/*/public/img/**/*.{gif,jpg,jpeg,png,svg}', gulp.series('process-img'));
});