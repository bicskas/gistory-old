<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class AuthLoginEventHandler {

	public function handle(Login $login) {
		$login->user->update(array(
			'last_login' => date('Y-m-d H:i:s'),
		));
	}

}
