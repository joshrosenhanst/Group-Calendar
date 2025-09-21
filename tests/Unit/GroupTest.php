<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Facades\FileHelper;
use App\Group;
use App\User;
use App\Event;
use App\Comment;

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
        $group = Group::factory()->create($data);

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
        $group = Group::factory()->create();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id
        ]);

        // create 10 group members
        User::factory()->count(10)->create()->each(function ($user) use ($group){
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

        // create 3 group admins
        User::factory()->count(3)->create()->each(function ($admin_user) use ($group){
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

    /*
        testCreateGroupWithInvites() - Test that the application can create a group, an admin user, and attach a set of group_invites.
        Check that the invited users, and pivot records exist in the database as we create them.
        The group->group_invites should exist and their count should match the number we created.
    */
    public function testCreateGroupWithInvites(){
        $group = Group::factory()->create();

        $admin_user = User::factory()->create();

        $group->users()->attach($admin_user->id, [
            'role' => 'admin'
        ]);

        User::factory()->count(6)->create()->each(function($invited_user) use ($group, $admin_user){
            $this->assertDatabaseHas('users', [
                'id' => $invited_user->id
            ]);

            $token = (string) Str::uuid();
            $group->group_invites()->attach($invited_user->id, [
                'creator_id' => $admin_user->id,
                'token' => $token
            ]);

            $this->assertDatabaseHas('group_invites', [
                'group_id' => $group->id,
                'user_id' => $invited_user->id,
                'creator_id' => $admin_user->id,
                'token' => $token
            ]);
        });

        $this->assertIsObject($group->group_invites);
        $this->assertCount(6, $group->group_invites);
    }

    /*
        testCreateGroupWithEvents() - Test that the application can create a group, a member, 2 upcoming events, and 3 past events.
        Check that the events exist as we create them. The group->events, group->upcoming_events, and group->past_events should exist and their count should match the number of events we create.
    */
    public function testCreateGroupWithEvents(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        // upcoming events
        Event::factory()->count(2)->states('upcoming')->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ])->each(function($event) use ($group,$member){
            $this->assertDatabaseHas('events', [
                'id' => $event->id,
                'group_id' => $group->id,
                'creator_id' => $member->id
            ]);
        });

        // past events
        Event::factory()->count(3)->states('past')->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ])->each(function($event) use ($group,$member){
            $this->assertDatabaseHas('events', [
                'id' => $event->id,
                'group_id' => $group->id,
                'creator_id' => $member->id
            ]);
        });

        $this->assertIsObject($group->events);
        $this->assertCount(5, $group->events);

        $this->assertIsObject($group->upcoming_events);
        $this->assertCount(2, $group->upcoming_events);

        $this->assertIsObject($group->past_events);
        $this->assertCount(3, $group->past_events);
    }

    /*
        testCreateGroupWithComments - Test that the application can create a group, a member, and 10 comments.
        Check that the comments exist as we create them. The group->comments should exist and their count should match the number of comments we create.
    */
    public function testCreateGroupWithComments() {
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        Comment::factory()->count(10)->create([
            'user_id' => $member->id,
            'commentable_id' => $group->id,
            'commentable_type' => \App\Group::class
        ])->each(function($comment) use ($group,$member){
            $this->assertDatabaseHas('comments', [
                'id' => $comment->id,
                'commentable_id' => $group->id,
                'commentable_type' => \App\Group::class,
                'user_id' => $member->id
            ]);
        });

        $this->assertIsObject($group->comments);
        $this->assertCount(10, $group->comments);
    }

    /*
        testUpdateGroup - Test that the application can update a group model and database record.
        Check that the model properties are properly updated.
    */
    public function testUpdateGroup(){
        $group = Group::factory()->create();

        $new_header_url = FileHelper::getRandomImageFromDirectory('default_headers','groups');
        $new_avatar_url = FileHelper::getRandomImageFromDirectory('default_avatars','avatars');
        $updated_group = [
            'name' => 'Updated Group Name',
            'header_url' => $new_header_url,
            'avatar_url' => $new_avatar_url
        ];

        $group->update($updated_group);
        $this->assertEquals($updated_group['name'], $group->name);
        $this->assertEquals($updated_group['header_url'], $group->header_url);
        $this->assertEquals($updated_group['avatar_url'], $group->avatar_url);
        Storage::disk('public')->assertExists('groups/'.$group->header_url);
        Storage::disk('public')->assertExists('avatars/'.$group->avatar_url);
    }
}
