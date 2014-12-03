<?php

class ScoresSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	    /* Table:Scores
	     ===================*/
	     
	    // Truncate
		DB::table('scores')->truncate();
	}
}
