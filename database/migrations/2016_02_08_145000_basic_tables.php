<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class BasicTables extends Migration {

	private $mezok = array(
		'seotitle',
		'seokeywords',
		'seodescription',
		'ogtitle',
		'ogdescription',
	);
	
	private function seo(Blueprint $table) {
		foreach ($this->mezok as $mezo) {
			$table->text($mezo);
		}
	}

	public function up() {
		
		// ----- tables ------

		Schema::create('szoveg', function(Blueprint $table) {
			$table->increments('id');
			$table->string('cim', 255);
			$table->string('link', 255);
			$table->text('szoveg');
			$this->seo($table);
		});
		
		Schema::create('menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('menu_id')->nullable()->unsigned()->index();
			$table->enum('tipus', array('fooldal','kapcsolat','szoveg','url','regisztracio'));
			$table->integer('szoveg_id')->nullable()->unsigned()->index();
			$table->string('nev', 255);
			$table->string('link', 255);
			$this->seo($table);
			$table->boolean('ujablak');
			$table->boolean('aktiv');
			$table->integer('sorrend')->unsigned();
		});

		// ------ foreign keys ------
		
		Schema::table('menu', function(Blueprint $table) {
			$table->foreign('menu_id')->references('id')->on('menu')->onUpdate('set null')->onDelete('set null');
			$table->foreign('szoveg_id')->references('id')->on('szoveg')->onUpdate('set null')->onDelete('set null');
		});

	}

	public function down() {
		Schema::drop('szoveg');
		Schema::drop('menu');
	}

}
