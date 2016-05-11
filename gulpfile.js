var elixir = require('laravel-elixir');
var util = require('gulp-util');

if ( ! util.env.production) {
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

elixir(function(mix) {
    mix.sass('app.scss');
    mix.scripts([
        'app.js'
    ]);
    mix.version(['css/app.css', 'js/all.js']);
    if ( ! util.env.production) {
        mix.browserSync({
            proxy: process.env.APP_URL
        });
    }
});
