var elixir = require('laravel-elixir');
var util = require('gulp-util');

if (!util.env.production) {
	var env = require('node-env-file');
	env(__dirname + '/.env');
}

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
	mix.sass('app.scss');
	mix.scripts(['jquery/dist/jquery.min.js',
		'bootstrap/dist/js/bootstrap.min.js',
		'typeahead.js/dist/typeahead.bundle.js',
		'bootstrap-select/dist/js/bootstrap-select.min.js',
		'd3.v3.min.js',
		'd3.min.js',
		'seiyria-bootstrap-slider/dist/bootstrap-slider.js'
	], 'public/js/vendor.js', 'public/vendor');
	mix.scripts(['app.js','circular.js','force_graph.js','bar.js'], 'public/js/app.js');
	mix.version(['css/app.css', 'js/vendor.js', 'js/app.js']);
	if (!util.env.production) {
		mix.browserSync({
			proxy: process.env.APP_URL,
			port: process.env.APP_PORT ? process.env.APP_PORT : Math.round(Math.random() * (30720 - 10240) + 10240),
			open: false
		});
	}
});
