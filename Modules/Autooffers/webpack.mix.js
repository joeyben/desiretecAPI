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

mix.js(__dirname + '/Resources/assets/js/modules/provider/autooffers/autooffers.js', 'js/modules/admin/autooffers/autooffers.js')
    .sass(__dirname + '/Resources/assets/sass/app.scss', __dirname + '/../../public/modules/css/offers.css');

if (mix.inProduction()) {
    mix.version();
}
