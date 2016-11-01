<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


/**
 * Profil oldal mentése
 */
class ProfilRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$user = \App\User::rules();
		unset($user['password']);
		unset($user['password_confirmation']);
		return $user;
	}

}
