<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApidocsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('apidocs', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('category');
            $table->string('subsystem');

            $table->enum('service_type', array('REST', 'SOAP','SDK'))->default("REST");
            $table->string('version');
            $table->string('short_code');
            $table->boolean('flag_need_authentication')->default(0);

            $table->string('name',400);
            $table->text('description');
            $table->text('notes')->nullable();

            $table->string('api_endpoint');
            $table->string('example_call_construct')->nullable();

            $table->enum('method', array('POST', 'GET','PUT','DELETE'))->default("GET");
            $table->enum('output_format', array('JSON', 'XML','TXT','CSV',"Serialized"))->default("JSON");

            $table->text('json_authentication_details')->nullable();
            $table->text('json_parameters_needed');

            $table->text('json_exceptions')->nullable();
            $table->text('json_error_codes')->nullable();

            $table->text('json_example_code')->nullable();
            $table->text('json_example_success')->nullable();
            $table->text('json_example_failure')->nullable();

            $table->string('original_author',100);
            $table->text('json_revisions')->nullable();

            $table->string('api_status');
            $table->boolean('flag_on')->default(1);

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
		Schema::drop('apidocs');
	}

}