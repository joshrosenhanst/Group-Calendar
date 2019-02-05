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
		$demo_group = factory(App\Group::class)->create();
		factory(App\User::class, 50)->create()->each(function($user) use ($demo_group){
			//add users to demo group
			$demo_group->users()->save($user);

			//create a comment on the group's page
			$comment = factory(App\Comment::class)->create([
				'user_id' => $user->id,
				'commentable_id' => $demo_group->id,
				'commentable_type' => App\Group::class
			]);
		});
	}
}
