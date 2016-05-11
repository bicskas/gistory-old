<?php

namespace App\Providers;

class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider {
	
	public function register() {
		$this->app->bind('mailer', function() {
			return new \App\Fedeisas\Mailer;
		});
		
		return parent::register();
	}

}
