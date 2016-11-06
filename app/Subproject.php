<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BasicModel;

class Subproject extends Model
{

	use BasicModel;

	protected $table = 'subproject';
	protected $fillable = array(
		'nev',
		'leiras',
	);
	public $timestamps = false;
	// orderByRaw, külön be kell állítani lekérdezésnél!
	public static $sorting = '`cim` ASC';

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
		return $this->hasMany('App\Edge','subproject_id','id');
	}


	public function createLink($projectid) {
//		return route('admin.' . $this->className() . '.show', $this);
		return "/project/".$projectid.'/'.$this->className() . '/' . $this->getRouteKey();
	}
}
