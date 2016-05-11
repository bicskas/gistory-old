<?php

namespace App\Http\Controllers\Admin;

use App\Szoveg;
use App\Menu as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class MenuController extends TemplateController {

	public function __construct() {
		parent::__construct();

		$this->class = 'menu';
		\View::share('aktiv_oldal', $this->class);
	}

	public function index(Request $request, Model $model) {
		
		$lista = $model
			->orderByRaw(Model::$sorting)
			->get();

		return view('admin.' . $this->class . '.lista', array(
			'lista' => $lista,
		));
	}

	private function save(ModelRequest $request, Model $model) {
		
		$data = $request->all();
		
		foreach (array('ujablak','aktiv') as $mezo) {
			if (!$request->get($mezo)) {
				$data[$mezo] = 0;
			}
		}
		
		foreach (array('szoveg_id','menu_id') as $mezo) {
			if (!$request->get($mezo)) {
				$data[$mezo] = null;
			}
		}
		
		if (!$model->sorrend) {
			$data['sorrend'] = (int) Model::max('sorrend') + 1;
		}
		
		$model->fill($data)->save();

		$model->kepfeltoltes($request->file('kep'));

		return redirect($model->adminLink() . '/edit')
			->with('uzenet', 'Sikeres mentés!');
	}

	private function szerkeszt(Request $request, Model $model, $method) {
		
		$tipusok = trans('admin.enum.menu.tipus');
		$szovegek = array(null => '(válasszon)') + Szoveg::orderByRaw(Szoveg::$sorting)
			->lists('cim', 'id')->all();
		$menuk = array(null => '(válasszon)') + Model::orderByRaw(Model::$sorting)
			->whereRaw('`menu`.`menu_id` IS NULL')
			->whereRaw($model->exists ? ('`menu`.`id` != ' . $model->id) : '1')
			->lists('nev', 'id')->all();
		
		return view('admin.' . $this->class . '.form', array(
			'model' => $model,
			'method' => $method,
			'tipusok' => $tipusok,
			'szovegek' => $szovegek,
			'menuk' => $menuk,
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
		return $this->szerkeszt($request, $model, 'put');
	}

	public function create(Request $request, Model $model) {
		return $this->szerkeszt($request, $model, 'post');
	}

	public function destroy(Model $model) {
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}

}
