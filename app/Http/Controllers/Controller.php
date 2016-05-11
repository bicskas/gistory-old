<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;
use App\Menu;

abstract class Controller extends BaseController {

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $menu;

	public function __construct() {
		
		if (!\App::runningInConsole()) {
			$this->menu = array_get(\Route::getCurrentRoute()->getAction(), 'menu');
		}

		View::share('aktiv_menu', $this->menu);
		if ($this->menu) {
			View::share('title', $this->menu->nev);
			View::share('seo_title', $this->menu->seotitle);
			View::share('seo_key', $this->menu->seokeywords);
			View::share('seo_desc', $this->menu->seodescription);
			View::share('og_title', $this->menu->ogtitle);
			View::share('og_desc', $this->menu->ogdescription);
			View::share('og_image', $this->menu->getImage() ? url($this->menu->getImage()) : null);
		}

		$fomenu = Menu::orderByRaw(Menu::$sorting)->aktiv()->fomenu()->get();
		View::share('fomenu', $fomenu);
	}

}
