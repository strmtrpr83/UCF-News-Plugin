var gulp = require('gulp'),
    configLocal = require('./gulp-config.json'),
    merge = require('merge'),
    sass = require('gulp-sass'),
    bless = require('gulp-bless'),
    rename = require('gulp-rename'),
    scsslint = require('gulp-scss-lint'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    readme = require('gulp-readme-to-markdown'),
    jshint = require('gulp-jshint'),
    jshintStylish = require('jshint-stylish'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    browserSync = require('browser-sync').create();

var configDefault = {
    scssPath: './src/scss',
    cssPath: './static/css',
    jsPath: './src/js',
    jsOutPath: './static/js',
  },
  config = merge(configDefault, configLocal);


// Lint all scss files
gulp.task('scss-lint', function() {
  gulp.src(config.scssPath + '/*.scss')
    .pipe(scsslint());
});

// Compile + bless primary scss files
gulp.task('css-main', function() {
  gulp.src(config.scssPath + '/ucf-news.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9'],
      cascade: false
    }))
    .pipe(cleanCSS({compatibility: 'ie9'}))
    .pipe(rename('ucf-news.min.css'))
    .pipe(bless())
    .pipe(gulp.dest(config.cssPath))
    .pipe(browserSync.stream());
});

gulp.task('js-hint', function() {
  gulp.src(config.jsPath + '/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'));
});

gulp.task('js-admin', function() {
  var minified = [
    config.jsPath + '/ucf-news-admin.js',
    config.jsPath + '/ucf-news-upload.js'
  ];

  gulp.src(minified)
    .pipe(concat('ucf-news-admin.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.jsOutPath));
});

gulp.task('js', ['js-hint', 'js-admin']);

// Create a Github-flavored markdown file from the plugin readme.txt
gulp.task('readme', function() {
  gulp.src(['readme.txt'])
    .pipe(readme({
      details: false,
      screenshot_ext: [],
    }))
    .pipe(gulp.dest('.'));
});


// All css-related tasks
gulp.task('css', ['scss-lint', 'css-main']);

// Rerun tasks when files change
gulp.task('watch', function() {
  if (config.sync) {
    browserSync.init({
        proxy: {
          target: config.target
        }
    });
  }

  gulp.watch(config.scssPath + '/**/*.scss', ['css']);
  gulp.watch(config.jsPath + '/*.js', ['js']).on('change', browserSync.reload);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
  gulp.watch('readme.txt', ['readme']);
});

// Default task
gulp.task('default', ['css', 'js', 'readme']);
