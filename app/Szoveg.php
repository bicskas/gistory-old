<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BasicModel;
use App\Traits\Kepfeltoltes;

class Szoveg extends Model {

	use BasicModel, Kepfeltoltes;

	protected $table = 'szoveg';
	protected $fillable = array(
		'cim',
		'link',
		'szoveg',
		'seotitle',
		'seokeywords',
		'seodescription',
		'ogtitle',
		'ogdescription',
	);
	public $timestamps = false;
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
		if (empty($this->link)) {
			$this->link = str_slug($this->cim);
		}
		if (empty($this->seotitle)) {
			$this->seotitle = $this->cim;
		}
		if (empty($this->ogtitle)) {
			$this->ogtitle = $this->cim;
		}

		return parent::save($options);
	}
	
	public function getLink() {
		return route($this->className(), $this->link);
	}

}
