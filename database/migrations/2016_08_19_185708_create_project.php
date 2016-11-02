<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id', false, true);
		    $table->string('cim', 255);
		    $table->string('leiras', 255);
		    $table->text('szoveg');
		    $table->timestamps();

			$table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project');

	}
}
