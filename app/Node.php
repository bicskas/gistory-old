<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BasicModel;
use App\Traits\Kepfeltoltes;

class Node extends Model
{

	use BasicModel, Kepfeltoltes;

	protected $table = 'node';
	protected $fillable = array(
		'nev',
	);
	public $timestamps = false;
	// orderByRaw, külön be kell állítani lekérdezésnél!
	public static $sorting = '`nev` ASC';

	protected function rules() {
		return array(
			'nev' => array(
				'required',
				'max:255',
			),
			'kep' => array(
				'image',
			),
		);
	}

	public function save(array $options = array()) {

		return parent::save($options);
	}

	public function getLink() {
		return route($this->className(), $this->link);
	}

	public function project(){
		return $this->belongsTo('App\Project','project_id','id');
	}

	public function edge()
	{
		return $this->belongsToMany('App\Node','edge','node1_id','node2_id');
	}

}
