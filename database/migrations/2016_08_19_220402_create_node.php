<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nev', 255);
            $table->integer('project_id',false,true)->nullable();
            $table->foreign('project_id')->references('id')->on('project')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(array('nev', 'project_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('node');
    }
}
