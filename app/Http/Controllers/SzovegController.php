<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Szoveg as Model;

class SzovegController extends Controller {

	public function index(Model $model) {
		
		$model = $this->menu ? $this->menu->szoveg : $model;

		return view('szoveg', array(
			'model' => $model,
			'title' => $model->cim,
			'seo_title' => $model->seotitle,
			'seo_key' => $model->seokeywords,
			'seo_desc' => $model->seodescription,
			'og_title' => $model->ogtitle,
			'og_desc' => $model->ogdescription,
			'og_image' => $model->getImage() ? url($model->getImage()) : null,
		));
	}

}
