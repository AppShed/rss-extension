var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    lessmap = require('gulp-less-sourcemap'),
    less = require('gulp-less'),
    del = require('del'),
    sourcemaps = require('gulp-sourcemaps'),
    uglifycss = require('gulp-uglifycss'),
    imagemin = require('gulp-imagemin'),
    path = require('path'),
    plumber = require('gulp-plumber');

gulp.task('default', ['build']);

gulp.task('build', ['fonts', 'css', 'styles:bundle', 'scripts:bundle', 'js', 'images']);

gulp.task('clean', function (cb) {
    del(['web/css/*', 'web/js/*', 'web/fonts/*'], cb);
});

gulp.task('styles:bundle', function() {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.min.css'
    ])
        .pipe(plumber())
        .pipe(uglifycss())
        .pipe(plumber.stop())
        .pipe(concat('bundle.css'))
        .pipe(gulp.dest('web/css'));
});
gulp.task('css', function() {
    return gulp.src([
        'web-src/css/*'
    ])
        .pipe(plumber())
        .pipe(less())
        .pipe(uglifycss())
        .pipe(plumber.stop())
        .pipe(concat('main.css'))
        .pipe(gulp.dest('web/css'));
});


gulp.task('scripts:bundle', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
    ])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('bundle.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('js', function() {
    return gulp.src(['web-src/js/**/*.js'])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        .pipe(concat('site.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('fonts', function () {
   return gulp.src(['node_modules/bootstrap/fonts/*', 'web-src/fonts/*'])
       .pipe(gulp.dest('web/fonts'))
});


gulp.task('images', function () {
    return gulp.src('web-src/images/**/*')
        .pipe(imagemin({
            progressive: true,
            interlaced: true
        }))
        .pipe(gulp.dest('web/images'));
});

gulp.task('watch', ['build'], function () {
    gulp.watch('web-src/less/*.less', ['styles']);
    gulp.watch('web-src/js/**/*.js', ['js']);
    gulp.watch('web-src/images/**/*', ['images']);
    gulp.watch('web-src/fonts/**/*', ['fonts']);
});