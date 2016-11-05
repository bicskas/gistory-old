<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Project as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller {

	public function __construct() {
		parent::__construct();

		$this->class = 'project';
		\View::share('aktiv_oldal', $this->class);

		$this->user = \Auth::user();
	}

	public function index() {

		$lista = Project::all();

		return view('project.lista', array(
			'lista' => $lista
		));
	}



	private function save(ModelRequest $request, Model $model) {

		$data = $request->all();

		$model->fill($data);//

		$this->user->project()->save($model);



		return redirect('/project')
			->with('uzenet', 'Sikeres mentés!');
	}

	private function szerkeszt(Model $model, $method) {

		return view( $this->class . '.form', array(
			'model' => $model,
			'method' => $method,
		));
	}

	public function show(Model $model) {
		return view($this->class . '.show', array(
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
