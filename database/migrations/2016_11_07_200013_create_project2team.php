<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject2team extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('project2team', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('project_id',false,true);
			$table->integer('team_id',false,true);
			$table->foreign('project_id')->references('id')->on('project')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('team_id')->references('id')->on('team')->onUpdate('cascade')->onDelete('cascade');

			$table->unique(array('project_id', 'team_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project2team');
	}
}
