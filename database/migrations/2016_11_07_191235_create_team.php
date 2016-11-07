<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('team', function(Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('leiras');
		    $table->integer('owner_id',false,true);
		    $table->foreign('owner_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

		    $table->unique(array('owner_id', 'name'));
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	    public function down()
    {
	    Schema::drop('team');
    }
}
