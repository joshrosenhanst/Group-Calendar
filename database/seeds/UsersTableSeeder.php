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
		$admin_group = App\Group::create([
			'name' => 'Init Group'
		]);
		$admin_user = App\User::create([
			'name' => 'Admin User',
			'email' => 'admin@groupcalendar.test',
			'password' => bcrypt('admin')
		]);

		$demo_group = factory(App\Group::class)->create();
		$admin_user->groups()->saveMany([
			$admin_group,
			$demo_group
		]);

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
