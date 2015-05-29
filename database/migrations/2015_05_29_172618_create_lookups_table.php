<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLookupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lookups', function(Blueprint $table)
		{
			$table->increments('id');


            $table->string('asset_type');
            $table->string('asset_id');

            $table->string('parent_asset_type');
            $table->string('parent_asset_id');

            $table->string('secondary_filter');

            $table->timestamps();
            $table->softDeletes();




		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lookups');
	}

}
