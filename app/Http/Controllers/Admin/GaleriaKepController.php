<?php

namespace App\Http\Controllers\Admin;

use App\Galeria;
use App\GaleriaKep as Model;
use App\Http\Requests\KepfeltoltesRequest;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class GaleriaKepController extends TemplateController {

	public function __construct() {
		parent::__construct();

		$this->class = 'galeria_kep';
		\View::share('aktiv_oldal', $this->class);
	}

	public function index(Request $request) {

		$model = Galeria::findOrFail($request->get('id'));
		
		$lista = $model
			->kep()
			->orderByRaw(Model::$sorting)
			->get();
		
		$ajax = view('admin.' . $this->class . '.ajax', array(
			'model' => $model,
			'lista' => $lista,
			'aktiv_oldal', $this->class,
		));
		
		if ($request->ajax()) {
			return $ajax;
		}

		return view('admin.' . $this->class . '.lista', array(
			'model' => $model,
			'lista' => $lista,
			'keplista' => $ajax,
		));

	}

	public function store(KepfeltoltesRequest $request) {

		$model = Galeria::findOrFail($request->get('id'));
		
		$upload = false;
		\DB::transaction(function() use ($request, $model, &$upload) {

			$kep = $model->kep()->create(array(
				'sorrend' => (int) $model->kep()->max('sorrend') + 1,
			));
			$upload = $kep->kepfeltoltes($request->file('file'));
		});

		return response()->json(array(), $upload ? 200 : 400);
	}

	public function destroy(Model $model) {
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}
}
