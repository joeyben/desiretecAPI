const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

var base_url = '../../';

mix.setPublicPath('../../public').mergeManifest();

mix.options({
    processCssUrls: false
});

mix.scripts(
    [
        base_url + "node_modules/jquery/dist/jquery.min.js",
        base_url + '/resources/assets/js/layer/datepicker.js',
        __dirname + '/Resources/assets/js/app.js'
    ], __dirname + '/../../public/whitelabel/overland/js/overland.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/resources/assets/js/layer/exitintent-new.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        base_url + '/resources/assets/js/layer/datepicker.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/overland/js/layer/layer.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/overland/js/layer/layer-locale.js')
    .sass(__dirname + '/Resources/assets/sass/layer/layer.scss', 'whitelabel/overland/css/layer/layer.css')
    .sass(base_url + '/resources/assets/sass/layer/_datepicker.scss', 'whitelabel/overland/css/datepicker.css')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'whitelabel/overland/css/overland.css')
    .styles([
        base_url + '/public/whitelabel/overland/css/datepicker.css',
        base_url + '/public/whitelabel/overland/css/layer/layer.css',
    ], __dirname + '/../../public/whitelabel/overland/css/layer/whitelabel.css')
    .copy(__dirname +'/Resources/assets/images/', __dirname +'/../../public/whitelabel/overland/images/')
    .copy(__dirname +'/Resources/assets/svg/', __dirname +'/../../public/whitelabel/overland/svg/');
if (mix.inProduction()) {
    mix.version();
}
