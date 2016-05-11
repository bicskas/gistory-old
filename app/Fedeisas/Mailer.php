<?php

namespace App\Fedeisas;

/**
 *
 */
class Mailer extends \Illuminate\Mail\Mailer {

	public function send($view, array $data, $callback, $original = false) {

		if ( ! $original) {
			$this->getSwiftMailer()->registerPlugin(new \App\Fedeisas\LaravelMailCssInliner\CssInlinerPlugin());
		}

		return parent::send($view, $data, $callback);
	}

}

// End Mailer
