var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var pleeease = require('gulp-pleeease');

gulp.task('sass', function(){
  gulp.src('assets/scss/*.scss')
  	.pipe(plumber())
    .pipe(sass())
    .pipe(pleeease({
        autoprefixer: {
            browsers: ["last 3 versions"]
        },
        minifier: false
    }))
    .pipe(gulp.dest('assets/css'));
});
gulp.task('watch', function(){
	gulp.watch(['assets/scss/*.scss'], ['sass']);
	gulp.watch(['assets/css/*.css']);
});
gulp.task('default', ['sass', 'watch']);
