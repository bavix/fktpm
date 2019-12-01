const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/awakening.js', 'public/js');
mix.sass('resources/sass/awakening.scss', 'public/css')
  .extract(['vue', 'axios', 'lodash', 'masonry-layout', 'vanilla-lazyload']);

mix.options({extractVueStyles: true});

mix.webpackConfig(webpack => {
  return {
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
      }
    }
  };
});

if (mix.inProduction()) {
  mix.version();
}
