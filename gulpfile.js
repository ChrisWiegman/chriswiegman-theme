var gulp = require('gulp');
var gulpMinify = require('gulp-minify');

function minify () {

    return gulp.src(['theme/scripts/*.js'])
        .pipe(gulpMinify({
            ignoreFiles: ['*-min.js']
        }))
        .pipe(gulp.dest('theme/scripts'));

}

exports.minify = minify;
exports.default = gulp.parallel(minify);
