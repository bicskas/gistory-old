<?php namespace App\Http\Controllers;

use App\Edge;
use App\Http\Controllers\Controller;
use App\Project;
use App\Node as Model;
use App\Http\Requests\ModelRequest;
use App\Subproject;
use File;
use Illuminate\Http\Request;
use Excel;
use Lava;

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

		return view('network.nodes', array(
			'nodes' => $nodes,
			'projectid' => $projectid,
		));
	}


	public function subprojectedge($projectid, $subprojectid)
	{

		$subproject = Subproject::find($subprojectid);

		$nodes = Project::find($projectid)->node()->orderBy('nev')->get();
		$chord = [];
		$force = ['nodes' => [], 'links' => []];

		foreach ($nodes as $n) {
			$targets = [];
			$force['nodes'][] = ['id' => str_slug($n->nev), 'group' => 1];

			foreach ($n->edge()->where('edge.subproject_id', '=', $subprojectid)->get() as $e) {
				$targets[] = $e->nev;
			}

			$chord[] = ['name' => $n->nev, 'size' => rand(600, 16000), 'imports' => $targets];

			$nevek[] = $n->nev;
			$degree[] = $n->subproject()->where('subproject_id', $subproject->id)->first()->pivot->degree;

		}
		foreach ($subproject->edge as $e) {
			$force['links'][] = ['source' => str_slug($e->node1->nev), 'target' => str_slug($e->node2->nev), 'value' => ($e->weight * 1)];
		}

		$file = "json/" . $projectid . '_' . $subproject->id . '_' . \Auth::user()->id . ".json";
		File::put($file, json_encode($chord));

		$forcefile = "json/" . $projectid . '_' . $subproject->id . '_' . \Auth::user()->id . "force.json";
		File::put($forcefile, json_encode($force));

		return view('network.lista', array(
			'nodes' => $nodes,
			'projectid' => $projectid,
			'subproject' => $subproject,
			'chord' => json_encode($chord),
			'force' => json_encode($force),
			'file' => $file,
			'forcefile' => $forcefile,
			'nevek' => json_encode($nevek),
			'degree' => json_encode($degree),
		));
	}

	public function compare($projectid)
	{

		$project = Project::find($projectid);

		$marvolt = [];
		$same = [];
		$diff = [];
		$results = [];
		$chord_same = [];
		$chord_diff = [];
		$force_same = ['nodes' => [], 'links' => []];
		$force_diff = ['nodes' => [], 'links' => []];
		$edges = Edge::whereIn('subproject_id', $project->subproject->lists('id')->toArray())->get();

		foreach ($edges as $edge) {
			$result = Edge::where(function ($query) use ($edge) {
				$query->where('node1_id', $edge->node1_id)->orWhere('node2_id', $edge->node1_id);
			})->where(function ($query) use ($edge) {
				$query->where('node1_id', $edge->node2_id)->orWhere('node2_id', $edge->node2_id);
			})->whereNotIn('id', $marvolt)->get();
			foreach ($result as $e) {
				$marvolt[] = $e->id;
			}
			$results[] = $result;
		}

		foreach ($results as $r) {
			if (!$r->isEmpty()) {
				if (count($r) == $project->subproject->count()) {
					$same[$r->first()->node1_id][] = $r;
				} else {
					$diff[$r->first()->node1_id][] = $r;
				}
			}
		}

		foreach ($project->node as $n) {
			$targets_same = [];
			$targets_diff = [];
			$force_same['nodes'][] = ['id' => str_slug($n->nev), 'group' => 1];
			$force_diff['nodes'][] = ['id' => str_slug($n->nev), 'group' => 1];

			if (array_key_exists($n->id, $same)) {
				foreach ($same[$n->id] as $e) {
					$targets_same[] = $e->first()->node2->nev;
				}
			}
			$chord_same[] = ['name' => $n->nev, 'size' => rand(600, 16000), 'imports' => $targets_same];

			if (array_key_exists($n->id, $diff)) {
				foreach ($diff[$n->id] as $e) {
					$targets_diff[] = $e->first()->node2->nev;
				}
			}
			$chord_diff[] = ['name' => $n->nev, 'size' => rand(600, 16000), 'imports' => $targets_diff];

			$nevek[] = $n->nev;
//			$degree[] = $n->subproject()->where('subproject_id', $project->id)->first()->pivot->degree;

		}
		foreach ($same as $edges) {
			foreach ($edges as $e) {
				$force_same['links'][] = ['source' => str_slug($e->first()->node1->nev), 'target' => str_slug($e->first()->node2->nev), 'value' => ($e->first()->weight * 10)];
			}
		}

		foreach ($diff as $edges) {
			foreach ($edges as $e) {
				$force_diff['links'][] = ['source' => str_slug($e->first()->node1->nev), 'target' => str_slug($e->first()->node2->nev), 'value' => ($e->first()->weight * 10)];
			}
		}

		$file_same = "json/" . $projectid . '_same_' . \Auth::user()->id . ".json";
		File::put($file_same, json_encode($chord_same));

		$forcefile_same = "json/" . $projectid . '_same_' . \Auth::user()->id . "force.json";
		File::put($forcefile_same, json_encode($force_same));

		$file_diff = "json/" . $projectid . '_diff_' . \Auth::user()->id . ".json";
		File::put($file_diff, json_encode($chord_diff));

		$forcefile_diff = "json/" . $projectid . '_diff_' . \Auth::user()->id . "force.json";
		File::put($forcefile_diff, json_encode($force_diff));

		return view('network.compare', array(
			'project' => $project,
			'projectid' => $projectid,
			'chord_same' => json_encode($chord_same),
			'force_same' => json_encode($force_same),
			'file_same' => $file_same,
			'forcefile_same' => $forcefile_same,
			'nevek' => json_encode($nevek),
			'chord_diff' => json_encode($chord_diff),
			'force_diff' => json_encode($force_diff),
			'file_diff' => $file_diff,
			'forcefile_diff' => $forcefile_diff,
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

	public function saveEdge(ModelRequest $request, Model $model, $projectid, $subprojectid)
	{
		$subproject = Subproject::find($subprojectid);
		$edge = new Edge();
		$edge->node1_id = Project::find($projectid)->node()->whereNev($request->get('nev1'))->first()->id;
		$edge->node2_id = Project::find($projectid)->node()->whereNev($request->get('nev2'))->first()->id;
		$edge->weight = $request->get('weight');
		$subproject->edge()->save($edge);
		set_degree($subproject);

		return redirect('/network/' . $projectid . '/' . $subprojectid)
			->with('uzenet', 'Sikeres mentette a kapcsolatot!');

	}

	public function downloadNode($projectid)
	{

		$project = Project::find($projectid);
		$adatok = $project->node;

		Excel::create(str_slug($project->cim), function ($excel) use ($adatok, $project) {
			$excel->setTitle($project->cim);
			$excel->sheet('Teljes hálózat', function ($sheet) use ($adatok) {

				$sheet->row(1, array(
					'id', 'Label'
				));
				$i = 2;
				foreach ($adatok as $n => $szemely) {
					$sheet->row($i + $n, array(
						$n + 1, $szemely->nev
					));
				}

			});

		})->store('csv', public_path('excel/' . str_slug($project->cim)))->download('csv');;

		return redirect()->back();
	}

	public function downloadEdge($projectid)
	{

		$project = Project::find($projectid);
		$adatok = $project->node;

		$nodes = [];
		foreach ($adatok as $n => $node) {
			$nodes[$node->id] = $n + 1;
		}
		$edges = [];

		foreach ($adatok as $node) {
			foreach ($node->edge as $edge) {
				$edges[] = $edge;
			}
		}


		Excel::create(str_slug($project->cim) . "_edges", function ($excel) use ($adatok, $project, $nodes) {
			$excel->setTitle($project->cim);
			$excel->sheet('Teljes hálózat', function ($sheet) use ($adatok, $nodes) {

				$sheet->row(1, array(
					'Source', 'Target', 'Type', 'Id'
				));
				$i = 2;
				foreach ($adatok as $node) {
					foreach ($node->edge as $edge) {
						$sheet->row($i, array(
							$nodes[$edge->pivot->node1_id], $nodes[$edge->pivot->node2_id], 'undirected', ($i - 1)
						));
						$i++;
					}
				}

				foreach ($adatok as $n => $szemely) {
					foreach ($szemely as $k => $kapcsolat) {
						if ($k > $n && !is_null($kapcsolat)) {
							$sheet->row($i, array(
								$n + 1, $k, 'undirected', ($i - 1)
							));
							$i++;
						}
					}
				}

			});

		})->store('csv', public_path('excel/' . str_slug($project->cim)))->download('csv');;

		return redirect()->back();
	}

	public function teszt()
	{
		/*$tabla = Excel::selectSheets('Munka1')->load(public_path('/userfiles/excel/kutatas.xlsx'));

  $adatok = $tabla->take(69)->toObject();

//      dd($adatok[0][0], $elem);
  Excel::create('Edges', function ($excel) use ($adatok) {
	  $excel->setTitle('Vissering kapcsolati h�l�');
	  $excel->sheet('Teljes h�l�zat', function ($sheet) use ($adatok) {

		  $sheet->row(1, array(
			  'Source', 'Target', 'Type', 'Id', 'Weight', 'Average Degree', 'color', 'Label'
		  ));
		  $i = 2;
		  foreach ($adatok as $n => $szemely) {
			  foreach ($szemely as $k => $kapcsolat) {
				  if ($k > $n && !is_null($kapcsolat)) {
					  $sheet->row($i, array(
						  $n + 1, $k, 'undirected', ($i - 1), config('edge.' . $kapcsolat.'.1'), 1, '255 , 0, 0', config('edge.' . $kapcsolat.'.0')
					  ));
					  $i++;
				  }
			  }
		  }

	  });

  })->store('csv', public_path('excel'));

  Excel::create('Edges', function ($excel) use ($adatok) {
	  $excel->sheet('Full network', function ($sheet) use ($adatok) {

		  $sheet->row(1, array(
			  'Source', 'Target', 'Type', 'Id', 'Weight', 'Average Degree', 'color', 'Label'
		  ));
		  $i = 2;
		  foreach ($adatok as $n => $szemely) {
			  foreach ($szemely as $k => $kapcsolat) {
				  if ($k > $n && !is_null($kapcsolat)) {
					  $sheet->row($i, array(
						  $n + 1, $k, 'undirected', ($i - 1), config('edge.' . $kapcsolat.'.1'), 1, '255 , 0, 0', config('edge.' . $kapcsolat.'.0')
					  ));
					  $i++;
				  }
			  }
		  }

	  });

  })->store('xlsx', public_path('excel'));

  Excel::create('Vissering_edges', function ($excel) use ($adatok) {
	  $excel->setTitle('Vissering kapcsolati h�l�');
	  $excel->sheet('Vissering kapcsolatati', function ($sheet) use ($adatok) {

		  $sheet->row(1, array(
			  'Source', 'Target', 'Type', 'Id', 'Weight', 'Average Degree','Color', 'Label'
		  ));
		  $i = 2;
		  foreach ($adatok as $n => $szemely) {
			  if ($n > 0) {
				  break;
			  }
			  foreach ($szemely as $k => $kapcsolat) {
				  if ($k > $n && !is_null($kapcsolat)) {
//                            dd(config('edge.' . $kapcsolat));
					  if ($kapcsolat < 7) {
						  $kapcsolat = 1;
						  $color = '0,0, 255';
					  } elseif ($kapcsolat == 7) {
						  $kapcsolat = 5;
						  $color = '0,255, 0';
					  } elseif ($kapcsolat > 7){
						  $kapcsolat = 9;
						  $color = '255,0, 0';
					  }
						  $sheet->row($i, array(
							  $n + 1, $k, 'undirected', ($i - 1), config('edge.' . $kapcsolat.'.1'), 1, $color,config('edge.' . $kapcsolat.'.0')
						  ));
					  $i++;
				  }
			  }
		  }

	  });

  })->store('csv', public_path('excel'));*/

		$tabla = Excel::selectSheets('Munka1')->load(public_path('/userfiles/excel/h_maria.xlsx'));

		$adatok = $tabla->take(27)->toObject();

		Excel::create('Hegedus_Maria', function ($excel) use ($adatok) {
			$excel->setTitle('Hegedűs Mária kapcsoalti háló');
			$excel->sheet('Teljes hálózat', function ($sheet) use ($adatok) {

				$sheet->row(1, array(
					'Source', 'Target', 'Type', 'Id', 'Weight', 'Average Degree', 'color', 'Label'
				));
				$i = 2;
				foreach ($adatok as $n => $szemely) {
					foreach ($szemely as $k => $kapcsolat) {
						if ($k > $n && !is_null($kapcsolat)) {
							$sheet->row($i, array(
								$n + 1, $k, 'undirected', ($i - 1), config('edge.' . $kapcsolat), 1, '255 , 0, 0', $kapcsolat
							));
							$i++;
						}
					}
				}

			});

		})->store('csv', public_path('excel'));


		return view('fooldal', array(
			'og_title' => null,
			'og_desc' => null,
			'seo_title' => null,
			'seo_desc' => null,
			'seo_key' => null
		));
	}


	public function destroy(Model $model)
	{
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}

	public function deleteEdge($edgeid)
	{
		$edge = Edge::find($edgeid);
		$subproject = $edge->subproject;
		$edge->delete();
		set_degree($subproject);

		return redirect('/network/' . $subproject->project->id . '/' . $subproject->id)->with('figyelmeztet', 'Kapcsolat törölve');
	}

}
