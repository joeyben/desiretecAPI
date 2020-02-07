const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();


mix.webpackConfig({
  module: {
    rules:[
      {

      }
    ]
  },
});

mix.js(__dirname + '/Resources/assets/js/modules/admin/whitelabels/whitelabels.js', 'js/modules/admin/whitelabels/whitelabels.js');

if (mix.inProduction()) {
  mix.version();
}
