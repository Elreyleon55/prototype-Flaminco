const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));

// Compile Sass to CSS
function compileSass() {
  return gulp
    .src("src/scss/**/*.scss") // Source SCSS files
    .pipe(sass().on("error", sass.logError)) // Compile Sass
    .pipe(gulp.dest("dist/css")); // Output CSS files
}

// Watch for changes in Sass files
function watchSass() {
  gulp.watch("src/scss/**/*.scss", compileSass);
}

// Default task
exports.default = gulp.series(compileSass, watchSass);
