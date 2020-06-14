// General Stuff
const browser = require("browser-sync").create();
const injector = require("bs-html-injector");
const gulp = require("gulp");
const path = require("path");
const rename = require("gulp-rename");
const gulpif = require("gulp-if");

const mode = process.env.NODE_ENV;

// Image Stuff
const imagemin = require("gulp-imagemin");

// CSS Stuff
const postcss = require("gulp-postcss");
const postcssimport = require("postcss-import");
const tailwind = require("tailwindcss");
const autoprefixer = require("autoprefixer");
const postcssnested = require("postcss-nested");
const minmax = require("postcss-media-minmax");
const purgecss = require("gulp-purgecss");
const csso = require("gulp-csso");

function purge() {
  return purgecss({
    content: ["templates/**/*.twig", "**/*.php"],
    defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],
  });
}

function optimize() {
  return csso({
    restructure: false,
  });
}

const plugins = [
  postcssimport(),
  tailwind(),
  autoprefixer(),
  postcssnested(),
  minmax(),
  // reporter()
];

// JS Stuff
const webpack = require("webpack-stream");
const strip = require("gulp-strip-comments");

gulp.task("images", () => {
  return gulp
    .src("src/images/*")
    .pipe(
      gulpif(mode === "production", imagemin({ options: { verbose: true } }))
    )
    .pipe(gulp.dest("dist/images/"));
});

gulp.task("videos", () => {
  return gulp.src("src/videos/*").pipe(gulp.dest("dist/videos/"));
});

gulp.task("css", () => {
  return gulp
    .src("src/styles/app.pcss")
    .pipe(postcss(plugins))
    .pipe(gulpif(mode === "production", purge()))
    .pipe(gulpif(mode === "production", optimize()))
    .pipe(rename("app.css"))
    .pipe(gulp.dest("dist"))
    .pipe(gulpif(mode === "development", browser.reload({ stream: true })));
});

gulp.task("blocks", () => {
  return gulp
    .src("src/styles/blocks.pcss")
    .pipe(postcss(plugins))
    .pipe(gulpif(mode === "production", purge()))
    .pipe(gulpif(mode === "production", optimize()))
    .pipe(rename("custom-blocks.css"))
    .pipe(gulp.dest("dist"))
    .pipe(gulpif(mode === "development", browser.reload({ stream: true })));
});

gulp.task("js", () => {
  return gulp
    .src("src/scripts/main.js")
    .pipe(
      webpack({
        mode,
        output: {
          path: path.resolve(__dirname, "dist"),
          filename: "main.js",
        },
        module: {
          rules: [
            {
              test: /\.js$/,
              include: path.resolve(__dirname, "src/scripts"),
              exclude: /node_modules/,
              use: {
                loader: "babel-loader",
                options: {
                  presets: [
                    [
                      "@babel/preset-env",
                      {
                        useBuiltIns: "usage",
                        corejs: 3,
                      },
                    ],
                  ],
                  plugins: ["@babel/plugin-proposal-class-properties"],
                  cacheDirectory: true,
                },
              },
            },
          ],
        },
      })
    )
    .pipe(strip())
    .pipe(gulp.dest("dist"));
});

gulp.task("reload", (done) => {
  browser.reload();
  done();
});

function server(done) {
  browser.use(injector, {
    files: "templates/**/*.twig",
  });

  browser.init({
    proxy: "http://lunatecs.test",
    ui: {
      port: 8080,
    },
  });
  done();
}

function watch() {
  gulp.watch("src/images/**/*", gulp.series("images", "reload"));
  gulp.watch("src/videos/**/*", gulp.series("videos", "reload"));
  gulp.watch("src/styles/**/*.pcss", gulp.series("css", "blocks"));
  gulp.watch("src/scripts/**/*.js", gulp.series("js", "reload"));
}

gulp.task(
  "default",
  gulp.series(
    gulp.parallel("images", "videos", "css", "blocks", "js"),
    server,
    watch
  )
);
gulp.task("build", gulp.parallel("images", "videos", "css", "blocks", "js"));
