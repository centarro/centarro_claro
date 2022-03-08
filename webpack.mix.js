let mix = require('laravel-mix')
let fs = require('fs-extra')

let getFiles = function (dir) {
  // get all 'files' in this directory
  // filter directories
  return fs.readdirSync(dir).filter(file => {
    if (!file.startsWith("_")) {
      return fs.statSync(`${dir}/${file}`).isFile();
    }
  });
};


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

getFiles('scss/').forEach(function (filepath) {
  mix.sass('scss/' + filepath, 'css/')
});


mix.options({
  processCssUrls: false,
  autoprefixer: {}
});