var 
    cssnano = require('gulp-cssnano'),
    concat = require('gulp-concat'),
    gulp = require('gulp'),
    less = require('gulp-less');

gulp.task('styles', function() {
    return gulp.src([
            'less/admin.less'
        ])
        .pipe(less())
        .on('error', swallowError)
        .pipe(concat('admin.min.css'))
        .pipe(cssnano())
        .pipe(gulp.dest('css/'));
});

gulp.task('default', ['styles']);

function swallowError (error) {

  // If you want details of the error in the console
  console.log(error.toString())

  this.emit('end')
}
