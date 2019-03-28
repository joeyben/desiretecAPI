const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

var base_url = '../../';

mix.setPublicPath('../../public').mergeManifest();

mix.scripts(
    [
        base_url + "node_modules/jquery/dist/jquery.min.js",
        base_url + '/resources/assets/js/layer/datepicker.js',
        __dirname + '/Resources/assets/js/app.js'
    ], __dirname + '/../../public/whitelabel/trendtours/js/trendtours.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        base_url + '/resources/assets/js/layer/datepicker.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/trendtours/js/layer/layer.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/trendtours/js/layer/layer-locale.js')
    .sass(__dirname + '/Resources/assets/sass/layer/layer.scss', 'whitelabel/trendtours/css/layer/layer.css')
    .sass(base_url + '/resources/assets/sass/layer/_datepicker.scss', 'whitelabel/trendtours/css/datepicker.css')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'whitelabel/trendtours/css/trendtours.css')
    .styles([
        base_url + '/public/whitelabel/trendtours/css/datepicker.css',
        base_url + '/public/whitelabel/trendtours/css/layer/layer.css',
    ], __dirname + '/../../public/whitelabel/trendtours/css/layer/whitelabel.css')
    .copy(__dirname +'/Resources/assets/images/', __dirname +'/../../public/whitelabel/trendtours/images/')
    .copy(__dirname +'/Resources/assets/svg/', __dirname +'/../../public/whitelabel/trendtours/svg/');
if (mix.inProduction()) {
    mix.version();
}