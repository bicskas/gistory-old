<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodeattributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('nodeattribute', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('degree');
			$table->integer('weightdegree');
			$table->integer('node_id',false,true);
			$table->integer('subproject_id',false,true);
			$table->foreign('node_id')->references('id')->on('node')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('subproject_id')->references('id')->on('subproject')->onUpdate('cascade')->onDelete('cascade');

			$table->unique(array('node_id','subproject_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nodeattribute');
	}
}
