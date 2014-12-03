<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('states', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("name");
			$table->string("capital");
			$table->decimal("area_mi", 10, 2);
			$table->decimal("area_km", 10, 2);
			$table->string("highest_point");
			$table->integer("highest_point_m"); 
			$table->integer("highest_point_ft");
			$table->string("img_caption")->nullable();
			$table->bigInteger("population");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('states');
	}

}
