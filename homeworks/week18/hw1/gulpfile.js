/* eslint-disable*/ 
// 是說因為沒引入，所以會產生錯誤，關於這部份我看其他同學的作業沒這問題，但我始終找不到原因
const { src, dest, parallel } = require('gulp');
const babel = require('gulp-babel');
const uglity = require('gulp-uglify');
const sass = require('gulp-sass');
const minifycss = require('gulp-minify-css');

function css() {
  return src('src/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifycss())
    .pipe(dest('output/'));
}

function javaScript() {
  return src('src/*.js')
    .pipe(babel({
      presets: ['@babel/preset-env'], // 放這邊可以取代另外開檔案
    }))
    .pipe(uglity())
    .pipe(dest('output/'));
}

exports.default = parallel(javaScript, css);
