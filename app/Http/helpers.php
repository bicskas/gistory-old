<?php

if (!function_exists('e')) {
	/**
	 * Escape HTML entities in a string.
	 *
	 * @param  string $value
	 * @return string
	 */
	function e($value)
	{
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
	}
}

if (!function_exists('inline_svg')) {
	/**
	 * inline svg beszúrása
	 * @param string $path file path
	 * @return string file tartalom
	 */
	function inline_svg($path)
	{
		return file_exists($path) ? preg_replace('/<\?xml.+\?>/', '', file_get_contents($path, true)) : false;
	}
}

if (!function_exists('url_get_contents')) {

	function url_get_contents($url, $post = null, $json_post = true)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if ($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			if ($json_post) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			}
		}
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
}

if (!function_exists('labels')) {
	function labels($mezo)
	{
		return trans('validation.attributes.' . $mezo);
	}
}

function __($key)
{
	if (Lang::has('messages.' . $key)) {
		return trans('messages.' . $key);
	}
	return $key;
}

function human_filesize($bytes, $decimals = 2)
{
	$sz = ' KMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @trim($sz[$factor]) . "B";
}

function set_degree($subproject)
{
	foreach ($subproject->node as $node) {
		$nodeattribute = $node->subproject()->where('subproject_id', $subproject->id)->first()->pivot;
		$edges = $subproject->edge()->where(function ($q) use ($node) {
			$q->where('node1_id', $node->id)->orWhere('node2_id', $node->id);
		})->get();
		$nodeattribute->degree = count($edges);
		$nodeattribute->weightdegree = 0;

		foreach ($edges as $edge) {
			$nodeattribute->weightdegree += $edge->weight;
		}
		$nodeattribute->save();
	}
}

function set_nodeCluster($subproject)
{
	$nodes = $subproject->node;
	foreach ($nodes as $node) {
		$triangles = 0;
		$nodeattribute = $node->subproject()->where('subproject_id', $subproject->id)->first()->pivot;

		$edges = $subproject->edge()->where(function ($q) use ($node) {
			$q->where('node1_id', $node->id)->orWhere('node2_id', $node->id);
		})->get();

		$exist = [];
		foreach ($edges as $edge1) {
			$neighbour1 = $edge1->node1_id != $node->id ? $edge1->node1_id : $edge1->node2_id;
			foreach ($edges as $edge2) {
				$neighbour2 = $edge2->node1_id != $node->id ? $edge2->node1_id : $edge2->node2_id;
				if ($neighbour1 != $neighbour2) {
					$result = App\Edge::where('subproject_id', $subproject->id)->where(function ($query) use ($neighbour1) {
						$query->where('node1_id', $neighbour1)->orWhere('node2_id', $neighbour1);
					})->where(function ($query) use ($neighbour2) {
						$query->where('node1_id', $neighbour2)->orWhere('node2_id', $neighbour2);
					})->whereNotIn('id', $exist)->first();
					if ($result) {
						$exist[] = $result->id;
						$triangles++;
					}
				}
			}
		}
		$nodeattribute->clustering = (2 * $triangles) / ($nodeattribute->degree * ($nodeattribute->degree - 1));
		$nodeattribute->save();
	}
}

function set_subprojectCluster($subproject)
{
	$nodes = $subproject->node;
	$clustering = 0;
	foreach ($nodes as $node) {
		$clustering += $node->pivot->clustering;
	}

	$subproject->clustering = $clustering / count($nodes);
	$subproject->save();
}