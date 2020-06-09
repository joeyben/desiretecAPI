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

mix.js(__dirname + '/Resources/assets/js/modules/provider/variants/variants.js', 'js/modules/provider/variants/variants.js');

if (mix.inProduction()) {
  mix.version();
}
