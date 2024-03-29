<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{
	protected $table = 'edge';
	public $timestamps = false;

	protected $fillable = array(
		'weight',
		'erosseg',
		'type',
	);

	public function node1()
	{
		return $this->belongsTo('App\Node', 'node1_id', 'id');
	}

	public function node2()
	{
		return $this->belongsTo('App\Node', 'node2_id', 'id');
	}

	public function subproject()
	{
		return $this->belongsTo('App\Subproject', 'subproject_id', 'id');
	}
}
