<?php

namespace App\Providers;

use Form;

class HtmlServiceProvider extends \Collective\Html\HtmlServiceProvider {

	public function boot() {
		$dir = 'elemek.form.';
		
		Form::component('bsText', $dir . 'bsText', ['id', 'model', 'attributes' => [], 'help' => '']);
		Form::component('bsTextarea', $dir . 'bsTextarea', ['id', 'model', 'attributes' => [], 'help' => '']);
		Form::component('bsSelect', $dir . 'bsSelect', ['id', 'model', 'options' => [], 'attributes' => [], 'help' => '']);
		Form::component('bsCheckbox', $dir . 'bsCheckbox', ['id', 'model', 'value' => 1, 'attributes' => [], 'help' => '']);
		Form::component('bsRadio', $dir . 'bsRadio', ['id', 'model', 'value' => 1, 'attributes' => [], 'help' => '']);
		Form::component('bsKep', $dir . 'bsKep', ['id', 'model']);
		Form::component('bsJcrop', $dir . 'bsJcrop', ['id', 'model']);
		Form::component('bsDropzone', $dir . 'bsDropzone', ['model', 'keplista' => '.keplista']);
		
		Form::component('mentes', $dir . 'mentes', []);
	}

}
