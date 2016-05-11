<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use File;

/**
 * Képfeltöltés, kivágás, törlés, satöbbi
 * kiegészítések kellenek még
 * 
 * használat: a Model classon belül 'use Kepfeltoltes'
 */
trait Kepfeltoltes {

	public function uploadDirectory() {
		return public_path() . '/userfiles/' . $this->className() . '/' . $this->id . '/';
	}

	public function kepfeltoltes($fajl) {
		if (is_null($fajl) || !$fajl->isValid()) {
			return false;
		}
		
		$this->deleteDirectory();

		$ext = $fajl->getClientOriginalExtension();
		$file = 'original.' . $ext;
		$dir = $this->uploadDirectory();

		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$upload = $fajl->move($dir, $file);
		Image::make($dir . $file)
			->resize(1920, 1920, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})
			->save($dir . $file);

		$className = $this->className();
		
		foreach (config('kepmeretek.' . $className, array()) as $ar => $widths) {
			foreach ($widths as $w) {
				$h = round($w / $ar);
				Image::make($dir . $file)
					->fit($w, $h)
					->save($dir . $w . 'x' . $h . '.' . $ext);
			}
		}

		return $upload;
	}
	
	public function cropolas(array $cropok) {
		$dir = $this->uploadDirectory();
		foreach ($cropok as $key => $kivagas) {
			$cropok[$key] = json_decode($kivagas, true);
		}
		if ($this->kivagasok != $cropok) {
			$meretek = config('kepmeretek.' . $this->className(), array());
			$original = public_path() . $this->getImage();
			$ext = pathinfo($original, PATHINFO_EXTENSION);
			foreach ($cropok as $ar => $c) {
				if ($c['w'] > 0 && $c['h'] > 0) {
					foreach (array_get($meretek, $ar, array()) as $width) {
						Image::make($original)
							->crop(round($c['w']), round($c['h']), round($c['x']), round($c['y']))
							->widen($width)
							->save($dir . $width . 'x' . round($width / $ar) . '.' . $ext, 85);
					}
				}
			}

			$this->kivagasok = $cropok;
			$this->save();
		}
		return true;
	}
	
	public function getKivagasok($key) {
		if (array_get($this->kivagasok, $key)) {
			return json_encode(array_get($this->kivagasok, $key));
		}
		$size = getimagesize(public_path() . $this->getImage());
		$original_size = array('x' => 0, 'y' => 0, 'x2' => $size[0], 'y2' => $size[1]);
		return json_encode($original_size);
	}

	public function getImage($ar = null, $w = null) {
		$dir = $this->uploadDirectory();
		
		$file = 'original.*';
		if (!is_null($ar) && !is_null($w)) {
			$h = round($w / $ar);
			$file = $w . 'x' . $h . '.*';
		}

		$files = glob($dir . $file);
		if (count($files) > 0) {
			return str_replace(public_path(), '', $files[0]);
		}

		if (isset($h)) {
			return 'http://placehold.it/' . $w . 'x' . $h . '?text=fezo-line';
		}
		return false;
	}
	
	public function deleteDirectory() {
		
		$dir = $this->uploadDirectory();
		
		return File::deleteDirectory($dir);
	}

	public function delete() {

		$this->deleteDirectory();

		return parent::delete();
	}

}
