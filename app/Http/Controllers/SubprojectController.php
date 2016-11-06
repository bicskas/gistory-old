<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Subproject;
use App\Subproject as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class SubprojectController extends Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->class = 'subproject';
		\View::share('aktiv_oldal', $this->class);

		$this->user = \Auth::user();
	}

	public function index($projectid, Model $model)
	{

		$lista = Project::find($projectid)->subproject;

		return view('subproject.lista', array(
			'lista' => $lista,
			'projectid' => $projectid
		));
	}


	private function save(ModelRequest $request, Model $model, $projectid)
	{

		$data = $request->all();

		$model->fill($data)->project()->associate($projectid)->save();


		return redirect()->back()
			->with('uzenet', 'Sikeres mentés!');
	}

	private function szerkeszt(Model $model, $method,$projectid)
	{

		return view($this->class . '.form', array(
			'model' => $model,
			'method' => $method,
			'projectid' => $projectid
		));
	}

	public function show(Model $model)
	{
		return view($this->class . '.show', array(
			'model' => $model,
		));
	}

	public function store(ModelRequest $request, Model $model,$projectid)
	{
		return $this->save($request, $model,$projectid);
	}

	public function update(ModelRequest $request, Model $model,$projectid)
	{
		return $this->save($request, $model,$projectid);
	}

	public function edit(Request $request, Model $model,$projectid)
	{
		return $this->szerkeszt($model, 'put',$projectid);
	}

	public function create(Model $model,$projectid)
	{
		return $this->szerkeszt($model, 'post',$projectid);
	}

	public function destroy(Model $model)
	{
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}

}
