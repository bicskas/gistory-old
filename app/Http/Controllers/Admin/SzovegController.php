<?php

namespace App\Http\Controllers\Admin;

use App\Szoveg as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class SzovegController extends TemplateController {

	public function __construct() {
		parent::__construct();

		$this->class = 'szoveg';
		\View::share('aktiv_oldal', $this->class);
	}

	public function index(Request $request, Model $model) {
		
		if (($data = $request->get('cim'))) {
			$model = $model->where('cim', 'LIKE', '%' . $data . '%');
		}
		
		$lista = $model
			->orderByRaw(Model::$sorting)
			->paginate(15);

		return view('admin.' . $this->class . '.lista', array(
			'lista' => $lista->appends($request->except('page')), // lapozó miatt!
		));
	}

	private function save(ModelRequest $request, Model $model) {
		
		$data = $request->all();
		
		$model->fill($data)->save();

		$model->kepfeltoltes($request->file('kep'));

		return redirect($model->adminLink() . '/edit')
			->with('uzenet', 'Sikeres mentés!');
	}
	
	private function szerkeszt(Model $model, $method) {
		
		return view('admin.' . $this->class . '.form', array(
			'model' => $model,
			'method' => $method,
		));
	}

	public function show(Model $model) {
		return view('admin.' . $this->class . '.show', array(
			'model' => $model,
		));
	}

	public function store(ModelRequest $request, Model $model) {
		return $this->save($request, $model);
	}

	public function update(ModelRequest $request, Model $model) {
		return $this->save($request, $model);
	}

	public function edit(Request $request, Model $model) {
		return $this->szerkeszt($model, 'put');
	}

	public function create(Model $model) {
		return $this->szerkeszt($model, 'post');
	}

	public function destroy(Model $model) {
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}
}
