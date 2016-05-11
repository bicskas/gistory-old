<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use App;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('inlinesvg', function($path) {
            return "<?php echo inline_svg{$path};?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		if (App::environment('production')) {
			$app_url = '^' . parse_url(config('app.url'), PHP_URL_HOST) . '$';
			Request::setTrustedHosts(array(
				$app_url
			));
		}
	}
}
