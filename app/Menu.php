<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Kepfeltoltes;
use App\Traits\BasicModel;

class Menu extends Model {
	
	use Kepfeltoltes, BasicModel;
	
	protected $table = 'menu';
	protected $fillable = array(
		'menu_id',
		'tipus',
		'szoveg_id',
		'nev',
		'link',
		'ujablak',
		'aktiv',
		'sorrend',
		'seotitle',
		'seokeywords',
		'seodescription',
		'ogtitle',
		'ogdescription',
	);
	public $timestamps = false;
	public static $sorting = '`sorrend` ASC';
	public $casts = array(
		'ujablak' => 'boolean',
		'aktiv' => 'boolean',
	);
	private $enum = array(
		'tipus' => array('fooldal','kapcsolat','szoveg','url'),
	);

	protected function rules() {
		return array(
			'ujablak' => 'boolean',
			'aktiv' => 'boolean',
			'sorrend' => 'numeric',
			'tipus' => array(
				'required',
				'in:' . implode(',', $this->enum('tipus')),
			),
			'szoveg_id' => array(
				'required_if:tipus,szoveg',
			),
			'kep' => array(
				'image',
			),
			'nev' => array(
				'required',
				'max:255',
			),
		);
	}
	
	public function save(array $options = array()) {
		if (empty($this->link)) {
			$this->link = str_slug($this->nev);
		}
		if (empty($this->seotitle)) {
			$this->seotitle = $this->nev;
		}
		if (empty($this->ogtitle)) {
			$this->ogtitle = $this->nev;
		}

		return parent::save($options);
	}
	
	public function scopeAktiv($query) {
		$query->where('aktiv', 1);
	}
	
	public function scopeFomenu($query) {
		$query->whereNull('menu_id');
	}
	
	public function szulo() {
		return $this->belongsTo('App\Menu', 'menu_id');
	}
	
	public function almenu() {
		return $this->hasMany('App\Menu', 'menu_id');
	}
	
	public function szoveg() {
		return $this->belongsTo('App\Szoveg', 'szoveg_id', 'id');
	}
	
	public function getLink() {
		if ($this->tipus == 'url') {
			return $this->link;
		}
		return url($this->link);
	}

}
