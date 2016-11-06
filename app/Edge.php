<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{
	protected $table = 'edge';
	public $timestamps = false;

	public function node1()
	{
		return $this->belongsTo('App\Node', 'node1_id', 'id');
	}

	public function node2()
	{
		return $this->belongsTo('App\Node', 'node2_id', 'id');
	}
}
