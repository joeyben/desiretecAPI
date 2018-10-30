const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

var base_url = '../../';

mix.setPublicPath('../../public').mergeManifest();

mix.js(
    [
        base_url + "node_modules/jquery/dist/jquery.min.js",
        __dirname + '/Resources/assets/js/app.js'
    ], 'whitelabel/tui/js/tui.js')
    .js([
        base_url + '/resources/assets/js/layer/exitintent.js',
        base_url + '/resources/assets/js/layer/base.js',
        __dirname + '/Resources/assets/js/layer/layer.js',
    ], 'whitelabel/tui/js/layer/layer.js')
    .sass(__dirname + '/Resources/assets/sass/layer/layer.scss', 'whitelabel/tui/css/layer/layer.css')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'whitelabel/tui/css/tui.css')
    .copy(__dirname +'/Resources/assets/images/', __dirname +'/../../public/whitelabel/tui/images/');
if (mix.inProduction()) {
    mix.version();
}