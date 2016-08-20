<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Node as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class NetworkController extends Controller {

	public function __construct() {
		parent::__construct();

		$this->class = 'network';
		\View::share('aktiv_oldal', $this->class);
	}

	public function index($projectid) {



		$nodes = Model::all();

		return view('network.lista', array(
			'nodes' => $nodes,
			'projectid' => $projectid
		));
	}

	public function createNode(ModelRequest $request, Model $model, $projectid){

		$data = $request->all();

		$model->fill($data)->save();


		return redirect('/network')
			->with('uzenet', 'Sikeres mentés!');
	}

}
