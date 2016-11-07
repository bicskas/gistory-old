<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Project as Model;
use App\Http\Requests\ModelRequest;
use App\Team;
use Illuminate\Http\Request;

class ProjectController extends Controller {

	public function __construct() {
		parent::__construct();

		$this->class = 'project';
		\View::share('aktiv_oldal', $this->class);

		$this->user = \Auth::user();
	}

	public function index() {

		$user = $this->user;
		$lista = $user->project;

		$shared = [];
		foreach ($user->teams as $team){
			foreach ($team->projects as $project){
				$shared[] = $project;
			}
		}

		foreach ($user->ownteam as $team){
			foreach ($team->projects as $project){
				$shared[] = $project;
			}
		}


		return view('project.lista', array(
			'lista' => $lista,
			'shared' => $shared
		));
	}

	public function subproject(Model $model,$projectid){

		$lista = $model->subproject;

		return view('subproject.lista', array(
			'lista' => $lista,
			'projectid' => $projectid
		));
	}



	private function save(ModelRequest $request, Model $model) {

		$data = $request->all();

		$model->fill($data);//

		$this->user->project()->save($model);

		$model->teams()->sync($request->get('teams', array()));

		return redirect('/project')
			->with('uzenet', 'Sikeres mentés!');
	}

	private function szerkeszt(Model $model, $method) {

		$own = $this->user->ownteam->lists('name', 'id')->all();
		$member = $this->user->teams->lists('name', 'id')->all();
		$teams =$own + $member;

		return view( $this->class . '.form', array(
			'model' => $model,
			'method' => $method,
			'teams' => $teams
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
