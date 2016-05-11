<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use View;

abstract class TemplateController extends BaseController {

	use ValidatesRequests;
	
	public function __construct() {

		View::share('aktiv_oldal', '');

	}

}
