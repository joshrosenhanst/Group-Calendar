<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Group;
use App\User;
use App\Comment;
use App\Facades\FileHelper;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$admin_group = Group::create([
			'name' => 'Init Group',
			'avatar_url' => FileHelper::copyDefaultImage('pexels-photo-1663417.jpg', 'default_avatars','avatars')
		]);
		$movie_group = Group::factory()->create([
			'name' => 'Movie Club',
			'header_url' => FileHelper::copyDefaultImage('pexels-photo-1353368.jpg', 'default_headers','groups')
		]);
		$concert_group = Group::factory()->create([
			'name' => 'Concert Goers',
			'header_url' => FileHelper::copyDefaultImage('pexels-photo-1190297.jpg', 'default_headers','groups')
		]);

		$admin_user = User::create([
			'name' => 'Admin User',
			'email' => 'admin@groupcalendar.test',
			'password' => bcrypt('admin'),
			'avatar_url' => FileHelper::copyDefaultImage('pexels-photo-1663417.jpg', 'default_avatars','avatars')
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

		User::factory()->count(50)->create()->each(function($user) use ($movie_group,$concert_group){
			//add users to demo groups
			$movie_group->users()->save($user);
			$concert_group->users()->save($user);

			$groups = [$movie_group->id, $concert_group->id];
			$random_group_comment = $groups[array_rand($groups)];

			//create a comment on the group's page
			$comment = Comment::factory()->create([
				'user_id' => $user->id,
				'commentable_id' => $random_group_comment,
				'commentable_type' => Group::class
			]);
		});
	}
}
