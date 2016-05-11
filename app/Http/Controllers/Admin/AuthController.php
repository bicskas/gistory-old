<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends TemplateController {
	/*
	  |--------------------------------------------------------------------------
	  | Registration & Login Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller handles the registration of new users, as well as the
	  | authentication of existing users. By default, this controller uses
	  | a simple trait to add these behaviors. Why don't you explore it?
	  |
	 */

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	public function __construct() {
		parent::__construct();
		
		$this->redirectPath = '/admin';
		$this->redirectAfterLogout = '/admin';
		$this->loginPath = '/admin/auth/login';
		$this->username = 'email';

		$this->middleware('guest', ['except' => 'getLogout']);
	}
	
	public function getLogin() {
		return view('admin.login');
	}
	
	public function getRegister() {
		return $this->getLogout();
	}

	public function postRegister() {
		return $this->getLogout();
	}
}
