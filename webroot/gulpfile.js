var 
    cssnano = require('gulp-cssnano'),
    concat = require('gulp-concat'),
    gulp = require('gulp'),
    less = require('gulp-less'),
    uglify = require('gulp-uglify');

gulp.task('styles', function() {
    return gulp.src([
            'less/bootstrap-select/bootstrap-select.less',
            'less/admin.less'
        ])
        .pipe(less())
        .on('error', swallowError)
        .pipe(concat('admin.min.css'))
        .pipe(cssnano())
        .pipe(gulp.dest('css/'));
});

gulp.task('scripts', function() {
    return gulp.src([
            'js/bootstrap-select/bootstrap-select.js',
            'js/admin.js',
        ])
        .pipe(concat('admin.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js/'));
});

gulp.task('default', ['styles', 'scripts']);

function swallowError (error) {

  // If you want details of the error in the console
  console.log(error.toString())

  this.emit('end')
}
