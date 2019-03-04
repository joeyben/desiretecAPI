// const { mix } = require('laravel-mix');
// // require('laravel-mix-merge-manifest');
// //
// // mix.setPublicPath('../../public').mergeManifest();
// //
// // mix.js(__dirname + '/Resources/assets/js/app.js', 'js/languagelines.js')
// //     .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/languagelines.css');
// //
// // if (mix.inProduction()) {
// //     mix.version();
// // }

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

mix.js(__dirname + '/Resources/assets/js/modules/provider/languagelines/languagelines.js', 'js/modules/admin/languagelines/languagelines.js');

if (mix.inProduction()) {
	mix.version();
}