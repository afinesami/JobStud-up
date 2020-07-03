// including plugins
var gulp = require('gulp')
var minify = require('gulp-minify');
 
gulp.task('default', function() {
  gulp.src('js/dev/*.js')
    .pipe(minify({
        ext:{
            src:'.js',
            min:'.min.js'
        },
        noSource: true,
        exclude: ['tasks'],
    }))
    .pipe(gulp.dest('js'))
});