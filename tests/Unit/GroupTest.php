<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class GroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /*
        testCreateGroup() - Test that the application create a Group model and database record.
        The test should insert a new Group into the database and then initialize the model normally. Check that the group exists in the database, properly copied the avatar/header images, and initialized accessor attributes on the model. 
    */
    public function testCreateGroup(){
        $data = [
            'name' => $this->faker->company
        ];
        $group = factory(\App\Group::class)->create($data);

        $this->assertInstanceOf(\App\Group::class, $group);
        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'name' => $group->name
        ]);
        $this->assertEquals($data['name'], $group->name);
        Storage::disk('public')->assertExists('avatars/'.$group->avatar_url);
        Storage::disk('public')->assertExists('groups/'.$group->header_url);
        $this->assertIsString($group->avatar);
        $this->assertIsString($group->header);
        $this->assertIsString($group->create_date);
        $this->assertEquals($group->create_date, $group->created_at->format('F Y'));
        // we haven't added any users yet, so it should be null
        $this->assertNull($group->users_count);
    }

    /*
        testCreateGroupWithUsers() - Test that the application can create a group and attach a set of users. Another set of users will have `admin` roles on the groups.
        Check that the group, users, and pivot records exist in the database as we create them.
        The group->users should exist and the group->user_count should be set.
    */
    public function testCreateGroupWithUsers(){
        $group = factory(\App\Group::class)->create();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id
        ]);

        factory(\App\User::class, 10)->create()->each(function ($user) use ($group){
            $this->assertDatabaseHas('users', [
                'id' => $user->id
            ]);
            $group->users()->save($user);
            $this->assertDatabaseHas('group_user', [
                'group_id' => $group->id,
                'user_id' => $user->id,
                'role' => 'member'
            ]);
        });

        factory(\App\User::class, 3)->create()->each(function ($admin_user) use ($group){
            $this->assertDatabaseHas('users', [
                'id' => $admin_user->id
            ]);
            $group->users()->attach($admin_user->id, [
                'role' => 'admin'
            ]);
            $this->assertDatabaseHas('group_user', [
                'group_id' => $group->id,
                'user_id' => $admin_user->id,
                'role' => 'admin'
            ]);
        });

        $this->assertIsObject($group->users);
        $this->assertCount(13, $group->users);

        // count is not automatically updated, needs manual refresh
        $group->refresh();
        $this->assertEquals(13,$group->users_count);
    }
}
