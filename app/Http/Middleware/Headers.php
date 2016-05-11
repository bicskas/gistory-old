<?php

namespace App\Http\Middleware;

use Closure;

class Headers {

	public function handle($request, Closure $next) {

		return $next($request)
				->header('X-Frame-Options', 'SAMEORIGIN')
				->header('X-Content-Type-Options', 'nosniff');
	}

}
