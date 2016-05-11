<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


/**
 * a _class_name-ben várja, h melyik modellről van szó
 */
class ModelRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$classname = $this->get('_class_name');
		if ($classname) {
			$cn = '\\' . $classname;
			return $cn::rules();
		}
		return array();
	}

}
