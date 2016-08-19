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
	    Schema::create('project', function(Blueprint $table) {
		    $table->increments('id');
		    $table->string('cim', 255);
		    $table->string('leiras', 255);
		    $table->text('szoveg');
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
