<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Node as Model;
use App\Http\Requests\ModelRequest;
use Illuminate\Http\Request;

class NetworkController extends Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->class = 'network';
		\View::share('aktiv_oldal', $this->class);
	}

	public function index($projectid)
	{

		$nodes = Project::find($projectid)->node()->orderBy('nev')->get();
		$edges = [];
		foreach ($nodes as $n) {
			if ($n->has('edge')) {
				$edges[] = $n;
			}
		}


		return view('network.lista', array(
			'nodes' => $nodes,
			'edges' => $edges,
			'projectid' => $projectid
		));
	}

	public function createNode(ModelRequest $request, Model $model, $projectid)
	{

		$data = $request->all();
		$model->fill($data)->project()->associate($projectid)->save();

//		$model->project()->associate($projectid)->save();

		return redirect('/network/' . $projectid)
			->with('uzenet', 'Sikeres mentés!');
	}

	public function saveEdge(ModelRequest $request, Model $model, $projectid)
	{

		$node1 = Project::find($projectid)->node()->whereNev($request->get('nev1'))->first();
		$node2 = Project::find($projectid)->node()->whereNev($request->get('nev2'))->first();

		$node1->edge()->attach($node2);

		return redirect('/network/' . $projectid)
			->with('uzenet', 'Sikeres mentette a kapcsolatot!');

	}

}
