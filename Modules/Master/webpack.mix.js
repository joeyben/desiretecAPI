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
        __dirname + '/Resources/assets/js/app.js',
    ], __dirname + '/../../public/whitelabel/master/js/master.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/resources/assets/js/layer/exitintent-new.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        base_url + '/resources/assets/js/layer/datepicker.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/master/js/layer/layer.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/master/js/layer/layer-locale.js')
    .sass(__dirname + '/Resources/assets/sass/layer/layer.scss', 'whitelabel/master/css/layer/layer.css')
    .sass(base_url + '/resources/assets/sass/layer/_datepicker.scss', 'whitelabel/master/css/datepicker.css')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'whitelabel/master/css/master.css')
    .styles([
        base_url + '/public/whitelabel/master/css/datepicker.css',
        base_url + '/public/whitelabel/master/css/layer/layer.css',
    ], __dirname + '/../../public/whitelabel/master/css/layer/whitelabel.css')
    .copy(__dirname +'/Resources/assets/images/', __dirname +'/../../public/whitelabel/master/images/')
    .copy(__dirname +'/Resources/assets/svg/', __dirname +'/../../public/whitelabel/master/svg/');
if (mix.inProduction()) {
    mix.version();
}
