<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BasicModel;
use App\Traits\Kepfeltoltes;

class Team extends Model
{

	use BasicModel, Kepfeltoltes;

	protected $table = 'team';
	protected $fillable = array(
		'name',
		'leiras',
	);
	public $timestamps = false;
	// orderByRaw, külön be kell állítani lekérdezésnél!
	public static $sorting = '`name` ASC';

	protected function rules()
	{
		return array(
			'name' => array(
				'required',
				'max:255',
			),
			'kep' => array(
				'image',
			),
		);
	}

	public function save(array $options = array())
	{

		return parent::save($options);
	}

	public function getLink()
	{
		return route($this->className(), $this->link);
	}

	public function users()
	{
		return $this->belongsToMany('App\User','user2team','user_id','team_id');
	}

	public function projects()
	{
		return $this->belongsToMany('App\Project','project2team','team_id','project_id');
	}

	public function owner(){
		return $this->belongsTo('App\User','owner_id','id');
	}
}
