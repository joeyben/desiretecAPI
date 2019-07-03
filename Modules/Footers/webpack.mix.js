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

mix.js(__dirname + '/Resources/assets/js/modules/admin/footers/footers.js', 'js/modules/admin/footers/footers.js');

if (mix.inProduction()) {
  mix.version();
}
