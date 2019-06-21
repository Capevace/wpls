const mix = require('laravel-mix');
const path = require('path');
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});
mix.options({ imgLoaderOptions: { enabled: false } })
    .js('resources/assets/js/index.js', 'js')
   .sass('resources/assets/sass/index.scss', 'css')
   .version();
mix.webpackConfig({
	node: false,
	output: {
 		// filename: '[name].[contenthash].js',
 		chunkFilename: 'js/[name].js'
	},
	plugins: [
		// new BundleAnalyzerPlugin({
		// 	analyzerPort: 9999
		// })
	]
});