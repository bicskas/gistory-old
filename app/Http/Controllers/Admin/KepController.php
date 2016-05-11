<?php

namespace App\Http\Controllers\Admin;

class KepController extends TemplateController {
	
	public function getTorol($snake_case, $id) {
		$studly_case = '\\App\\' . studly_case($snake_case);
		
		$m = new $studly_case;
		if ($m) {
			$model = $m->find($id);
			if ($model && is_callable(array($model, 'deleteDirectory'))) {
				$model->deleteDirectory();
			}
		}
		
		return redirect()->back();
	}
}