<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateAdmin {

	protected $auth;

	public function __construct(Guard $auth) {
		$this->auth = $auth;
	}

	public function handle($request, Closure $next) {

		if ($this->auth->user() && $this->auth->user()->hasRole('admin')) {
			return $next($request);
		}

		if ($request->ajax()) {
			return response('Unauthorized.', 401);
		} else {
			$this->auth->logout();
			return redirect()->guest('admin/auth/login');
		}
	}

}
