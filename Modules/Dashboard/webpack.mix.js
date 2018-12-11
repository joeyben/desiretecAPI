const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.webpackConfig({
  module: {
    rules:[
      {
        enforce: 'pre',
        test: /\.(js|vue)$/,
        exclude: /(node_modules|bower_components)/,
        loader: 'eslint-loader',
        options: {
          fix: true
        }
      }
    ]
  },
});

mix.js(__dirname + '/Resources/assets/js/modules/provider/dashboard/dashboard.js', 'js/modules/provider/dashboard/dashboard.js');

if (mix.inProduction()) {
    mix.version();
}
