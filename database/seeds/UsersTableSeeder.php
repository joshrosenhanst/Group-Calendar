<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//$group = factory(App\Group::class)->make();
		factory(App\User::class, 50)->create()->each(function($user){
			//add users to demo group
			//store their photos
		});
	}
}
