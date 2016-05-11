<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AjaxController extends TemplateController {

	public function postSorrend(Request $request, $model) {

		parse_str($request->get('data'), $array);
		$i = 1;
		$array = array_pop($array);

		$className = '\\App\\' . studly_case($model);
		$model = new $className;
		foreach ($array as $a) {
			$model
				->find($a)
				->update(array(
					'sorrend' => $i++
				));
		}
	}

}
