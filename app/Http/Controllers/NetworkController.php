<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Project;
use App\Node as Model;
use App\Http\Requests\ModelRequest;
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
		$edges = [];
		$json = [];
		$force = ['nodes' => [], 'links' => []];

		$stocksTable = Lava::DataTable();  // Lava::DataTable() if using Laravel

		$stocksTable->addStringColumn('Név')
			->addNumberColumn('Fokszám');



		foreach ($nodes as $n) {
			$targets = [];

			$force['nodes'][] = ['id' => $n->nev, 'group' => 1];
			if ($n->has('edge')) {
				$edges[] = $n;

				foreach ($n->edge as $e) {
					$targets[] = $e->nev;
					$force['links'][] = ['source' => $n->nev, 'target' => $e->nev, 'value' => 1];
				}
			}
			$stocksTable->addRow([
				$n->nev, count($n->edge)
			]);
			$json[] = ['name' => $n->nev, 'size' => rand(600, 16000), 'imports' => $targets];


			$nevek[] = $n->nev;
			$degree[] = count($n->edge);

//			$force['links'] = array_add(['source'=> $n->nev,'target' => 1,'value' => 1]);
		}

//		dd(json_encode($force));
		$file = "json/" . $projectid . '_' . \Auth::user()->id . ".json";
		File::put($file, json_encode($json));

		$forcefile = "json/" . $projectid . '_' . \Auth::user()->id . "force.json";
		File::put($forcefile, json_encode($force));



// Random Data For Example
		$chart = Lava::BarChart('MyStocks', $stocksTable,['height' => 2000]);



		return view('network.lista', array(
			'nodes' => $nodes,
			'edges' => $edges,
			'projectid' => $projectid,
			'json' => json_encode($json),
			'force' => json_encode($force),
			'file' => $file,
			'forcefile' => $forcefile,
			'chart' => $chart,
			'nevek' => json_encode($nevek),
			'degree' => json_encode($degree),
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


	public function destroy(Model $model) {
		$model->delete();
		return array(
			'id' => $model->id,
		);
	}

}
