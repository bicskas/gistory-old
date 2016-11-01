<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;


class AuthController extends Controller {
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

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->redirectPath = '/home';
		$this->redirectAfterLogout = '/';
		$this->loginPath = '/auth/login';
		$this->name = 'email';

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, User::rules() + array(
				'password' => array(
					'required',
					'confirmed',
					'min:6',
				),
			));
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data) {

		$data['password'] = array_get($data, 'password');

		return User::create($data);
	}

}
