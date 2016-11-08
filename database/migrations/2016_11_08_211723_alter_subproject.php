<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSubproject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('subproject', function (Blueprint $table) {
			$table->float('clustering')->nullable();
			$table->float('transitivity')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subproject', function (Blueprint $table) {
			$table->dropColumn('clustering');
			$table->dropColumn('transitivity');
		});
	}
}
