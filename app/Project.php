<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BasicModel;
use App\Traits\Kepfeltoltes;

class Project extends Model
{

	use BasicModel, Kepfeltoltes;

	protected $table = 'project';
	protected $fillable = array(
		'cim',
		'leiras',
		'szoveg',
	);
	public $timestamps = true;
	// orderByRaw, külön be kell állítani lekérdezésnél!
	public static $sorting = '`cim` ASC';

	protected function rules() {
		return array(
			'cim' => array(
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
}
