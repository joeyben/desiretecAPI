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
    ], __dirname + '/../../public/whitelabel/olimar/js/olimar.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/resources/assets/js/layer/exitintent-new.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        base_url + '/resources/assets/js/layer/datepicker.js',
        base_url + '/resources/assets/js/layer/devicedetector.min.js',
        base_url + '/resources/assets/js/layer/touchswipe.js',
        base_url + '/resources/assets/js/layer/typeahead.js',
        base_url + '/resources/assets/js/layer/bootstrap3-typeahead.min.js',
        base_url + '/resources/assets/js/layer/tagsinput.min.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/olimar/js/layer/layer.js')
    .scripts([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/node_modules/js-cookie/src/js.cookie.js',
        base_url + '/resources/assets/js/layer/base.js',
        base_url + '/resources/assets/js/layer/rangeslider.js',
        base_url + '/resources/assets/js/layer/touchswipe.js',
        base_url + '/resources/assets/js/layer/devicedetector.min.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], __dirname + '/../../public/whitelabel/olimar/js/layer/layer-locale.js')
    .sass(__dirname + '/Resources/assets/sass/layer/_layer.scss', 'whitelabel/olimar/css/layer/layer.css')
    .sass(__dirname + '/Resources/assets/sass/layer/_layer-responsive.scss', 'whitelabel/olimar/css/layer/layer-responsive.css')
    .sass(base_url + '/resources/assets/sass/layer/_datepicker.scss', 'whitelabel/olimar/css/datepicker.css')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'whitelabel/olimar/css/olimar.css')
    .styles([
        base_url + '/public/whitelabel/olimar/css/datepicker.css',
        base_url + '/public/whitelabel/olimar/css/layer/layer.css',
        base_url + '/public/whitelabel/olimar/css/layer/layer-responsive.css',
    ], __dirname + '/../../public/whitelabel/olimar/css/layer/whitelabel.css')
    .copy(__dirname +'/Resources/assets/images/', __dirname +'/../../public/whitelabel/olimar/images/')
    .copy(__dirname +'/Resources/assets/svg/', __dirname +'/../../public/whitelabel/olimar/svg/');
if (mix.inProduction()) {
    mix.version();
}