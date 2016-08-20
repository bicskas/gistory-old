<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edge', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('weight');
            $table->float('erosseg');
            $table->integer('node1_id',false,true);
            $table->integer('node2_id',false,true);
            $table->foreign('node1_id')->references('id')->on('node')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('node2_id')->references('id')->on('node')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('edge');
    }
}
