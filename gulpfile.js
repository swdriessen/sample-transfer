var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(){
	return gulp.src(['sass/bootstrap.scss', 'sass/site.scss'])
	.pipe(sass({outputStyle: 'compressed'}))
	.pipe(gulp.dest('src/public/css'))
});

gulp.task('js', function(){
	return gulp.src(['node_modules/bootstrap/dist/js/bootstrap.min.js'])
	.pipe(gulp.dest('src/public/js'))
});

gulp.task('observe', function(){
	gulp.watch(['sass/**/*.scss'], ['sass']);
});

gulp.task('default', ['js', 'observe']);