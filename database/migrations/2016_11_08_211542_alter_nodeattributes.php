<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNodeattributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('nodeattribute', function (Blueprint $table) {
			$table->float('clustering')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('nodeattribute', function (Blueprint $table) {
			$table->dropColumn('clustering');
		});
	}
}
