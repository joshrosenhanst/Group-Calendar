<?php

use Illuminate\Database\Seeder;
use App\FileHelper;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$filehelper = new FileHelper;

		$admin_group = App\Group::create([
			'name' => 'Init Group',
			'avatar_url' => $filehelper->copyDefaultImage('pexels-photo-1663417.jpg', 'default_avatars','avatars')
		]);
		$movie_group = factory(App\Group::class)->create([
			'name' => 'Movie Club',
			'header_url' => $filehelper->copyDefaultImage('pexels-photo-1353368.jpg', 'default_headers','groups')
		]);
		$concert_group = factory(App\Group::class)->create([
			'name' => 'Concert Goers',
			'header_url' => $filehelper->copyDefaultImage('pexels-photo-1190297.jpg', 'default_headers','groups')
		]);

		$admin_user = App\User::create([
			'name' => 'Admin User',
			'email' => 'admin@groupcalendar.test',
			'password' => bcrypt('admin'),
			'avatar_url' => $filehelper->copyDefaultImage('pexels-photo-1663417.jpg', 'default_avatars','avatars')
		]);
		$admin_group->users()->attach($admin_user->id,[
			'role'=>'admin'
		]);
		$movie_group->users()->attach($admin_user->id, [
			'role'=>'admin'
		]);
		$concert_group->users()->attach($admin_user->id, [
			'role'=>'admin'
		]);

		factory(App\User::class, 50)->create()->each(function($user) use ($movie_group,$concert_group){
			//add users to demo groups
			$movie_group->users()->save($user);
			$concert_group->users()->save($user);

			//create a comment on the group's page
			$comment = factory(App\Comment::class)->create([
				'user_id' => $user->id,
				'commentable_id' => array_rand([$movie_group->id, $concert_group->id]),
				'commentable_type' => App\Group::class
			]);
		});
	}
}
