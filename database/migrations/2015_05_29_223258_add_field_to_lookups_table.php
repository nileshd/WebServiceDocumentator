<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToLookupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lookups', function(Blueprint $table)
		{
            $table->string('tertiary_filter');
            $table->string('asset_label');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lookups', function(Blueprint $table)
		{
			//
		});
	}

}
