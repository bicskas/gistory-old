<?php

namespace App\Traits;

trait BasicModel {
	
	protected function rules() {
		return array();
	}
	
	public function adminLink() {
//		return route('admin.' . $this->className() . '.show', $this);
		return '/admin/' . $this->className() . '/' . $this->getRouteKey();
	}

	public function createLink() {
//		return route('admin.' . $this->className() . '.show', $this);
		return $this->className() . '/' . $this->getRouteKey();
	}

	public function className() {
		return snake_case(class_basename(__CLASS__));
	}

	protected function enum($param = null) {
		if (is_null($param)) {
			return $this->enum;
		}
		return array_get($this->enum, $param, array());
	}
}
