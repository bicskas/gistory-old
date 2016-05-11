<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class KepfeltoltesRequest extends Request {

	private $field = 'file';
	
	public function authorize() {
		return true;
	}
	
	public function rules() {
		return array(
			$this->field => array(
				'required',
				'image',
				'max:10000',
			),
		);
	}

	protected function formatErrors(Validator $validator) {
		return array(
			'error' => implode(', ', array_get($validator->errors()->getMessages(), $this->field, array())),
		);
	}

}
