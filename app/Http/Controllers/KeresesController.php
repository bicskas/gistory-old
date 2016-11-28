<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Node;
use App\Project;
use Illuminate\Http\Request;

class KeresesController extends Controller
{

	public function index(Request $request){
		$kepviselo = Kepviselo::whereNev($request->get('kepviselo_nev'))->first();
		if($kepviselo){
			return redirect('/kepviselo/'.$kepviselo->id);
		}
		return redirect('/kepviselok');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function node($project,$nev)
	{
		$nodes = $project->node()->where('nev', 'LIKE', '%' . $nev . '%')->get();
		return json_encode($nodes);
	}

}
