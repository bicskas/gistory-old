<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser2team extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('user2team', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id',false,true);
			$table->integer('team_id',false,true);
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('team_id')->references('id')->on('team')->onUpdate('cascade')->onDelete('cascade');

			$table->unique(array('user_id', 'team_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user2team');
	}
}
