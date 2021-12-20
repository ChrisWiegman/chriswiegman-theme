var gulp = require("gulp");
var gulpSass = require("gulp-sass")(require("sass"));
var rename = require("gulp-rename");
var sourcemaps = require("gulp-sourcemaps");
const del = require("del");

function clean() {
  return del(["./assets/*.css"]);
}

function sass() {
  gulpSass.compiler = require("node-sass");

  return gulp
    .src("./assets/scss/main.scss")
    .pipe(sourcemaps.init())
    .pipe(gulpSass().on("error", gulpSass.logError))
    .pipe(rename("main.css"))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest("./assets/"));
}

function editorSass() {
  gulpSass.compiler = require("node-sass");

  return gulp
    .src("./assets/scss/editor.scss")
    .pipe(gulpSass().on("error", gulpSass.logError))
    .pipe(rename("editor.css"))
    .pipe(gulp.dest("./assets/"));
}

function sassMin() {
  gulpSass.compiler = require("node-sass");

  return gulp
    .src("./assets/scss/main.scss")
    .pipe(
      gulpSass({ outputStyle: "compressed" }).on("error", gulpSass.logError)
    )
    .pipe(rename("main.min.css"))
    .pipe(gulp.dest("./assets/"));
}

// Watch files
function watchFiles() {
  gulp.watch("./assets/scss/**/*", sass, sassMin, editorSass);
}

const build = gulp.series(clean, sass, sassMin, editorSass);
const watch = gulp.parallel(watchFiles);

exports.editorSass = editorSass;
exports.sassMin = sassMin;
exports.sass = sass;
exports.clean = clean;
exports.build = build;
exports.watch = watch;
exports.default = build;
