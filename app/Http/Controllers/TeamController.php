<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Team;
use App\Team as Model;
use App\Http\Requests\ModelRequest;
use App\User;
use Illuminate\Http\Request;

class TeamController extends Controller {

	public function __construct() {
		parent::__construct();

		$this->class = 'team';
		\View::share('aktiv_oldal', $this->class);

		$this->user = \Auth::user();
	}

	public function index() {

		$user = $this->user;
		$lista = $user->ownteam;
		$teams = $user->teams;

		return view('team.lista', array(
			'lista' => $lista,
			'teams' => $teams
		));
	}

	public function addteam(ModelRequest $request, Model $model,$teamid){
		$model = $model->find($teamid);
		if($this->user->id != $model->owner_id){
			dd($model);
			return redirect('/team');
		}


		$member = User::whereEmail($request->get('email'))->first();
		$model->users()->attach($member);

		return redirect()->back()->with('uzenet', 'A falhasználó sikeresen hozzáadva');
	}

	private function save(ModelRequest $request, Model $model) {
		$data = $request->all();

		$model->fill($data);//

		$this->user->ownteam()->save($model);



		return redirect('/team')
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
