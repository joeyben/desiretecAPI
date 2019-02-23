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

mix.js(__dirname + '/Resources/assets/js/modules/user/notifications/notifications.js', 'js/modules/user/notifications/notifications.js')
   .js(__dirname + '/Resources/assets/js/modules/user/inbox/inbox.js', 'js/modules/user/inbox/inbox.js');

if (mix.inProduction()) {
  mix.version();
}
