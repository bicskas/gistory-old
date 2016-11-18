<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;

class FooldalController extends Controller {

	public function index() {
		if(!Auth::user()){
			return view('welcome', array(
			));
		}


		return view('fooldal', array(
		));
	}

}
