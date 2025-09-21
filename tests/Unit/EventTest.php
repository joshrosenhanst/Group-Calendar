<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Facades\FileHelper;
use App\Group;
use App\User;
use App\Event;
use App\Comment;

class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /*
        testCreateEvent() - Test that the application can create an Event model and database record.
        The test should create a new group, member, and an event using the group and member. 
        Check that the model properties are set properly and that the model accessor attributes are initialized.
    */
    public function testCreateEvent(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        $event = Event::factory()->create([
            'group_id' => $group->id,
            'creator_id' => $member->id,
            'end_date' => Carbon::today()->addWeeks(3)->format("Y-m-d"),
            'end_time' => $this->faker->time('H:i'),
        ]);

        $this->assertInstanceOf(\App\Event::class, $event);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'group_id' => $group->id,
            'creator_id' => $member->id
        ]);
        Storage::disk('public')->assertExists('events/'.$event->header_url);
        $this->assertIsString($event->header);
        $this->assertIsString($event->summary_date);
        $this->assertIsString($event->start_time_subtext);

        $this->assertIsString($event->city_state);
        $this->assertEquals(($event->location_city . ", " . $event->location_state), $event->city_state);

        $this->assertIsObject($event->group);
        $this->assertEquals($group->id, $event->group->id);

        $this->assertIsObject($event->creator);
        $this->assertEquals($member->id, $event->creator->id);

        // there is no Auth::user by default for tests, so the user_status should default to 'pending'
        $this->assertEquals('pending', $event->user_status);
        // we haven't updated the event yet, so the event->updater should be null
        $this->assertNull($event->updater);
        // a new event has no attendees
        $this->assertEmpty($event->attendees);
        // a new event has no comments
        $this->assertEmpty($event->comments);
    }

    /*
        testCreateEventWithAttendees() - Test that the application can create an event and attach 4 going attendees, 3 unavailable attendees, and 5 interested attendees.
        Check that the event, users, and pivot records exist in the database as we create them.
        The event->attendees, event->going_attendees, event->interested_attendees should exist and match the number of created attendees.
    */
    public function testCreateEventWithAttendees(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        $event = Event::factory()->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ]);

        // create 4 group members and set their attendee status to going
        User::factory()->count(4)->create()->each(function ($user) use ($group,$event){
            $group->users()->save($user);
            $event->attendees()->attach($user->id, [
                'status' => 'going'
            ]);
            $this->assertDatabaseHas('event_user', [
                'event_id' => $event->id,
                'user_id' => $user->id,
                'status' => 'going'
            ]);
        });

        // create 3 group members and set their attendee status to unavailable
        User::factory()->count(3)->create()->each(function ($user) use ($group,$event){
            $group->users()->save($user);
            $event->attendees()->attach($user->id, [
                'status' => 'unavailable'
            ]);
            $this->assertDatabaseHas('event_user', [
                'event_id' => $event->id,
                'user_id' => $user->id,
                'status' => 'unavailable'
            ]);
        });

        // create 5 group members and set their attendee status to interested
        User::factory()->count(5)->create()->each(function ($user) use ($group,$event){
            $group->users()->save($user);
            $event->attendees()->attach($user->id, [
                'status' => 'interested'
            ]);
            $this->assertDatabaseHas('event_user', [
                'event_id' => $event->id,
                'user_id' => $user->id,
                'status' => 'interested'
            ]);
        });

        $this->assertIsObject($event->attendees);
        $this->assertCount(12, $event->attendees);

        $this->assertIsObject($event->going_attendees);
        $this->assertCount(4, $event->going_attendees);

        $this->assertIsObject($event->interested_attendees);
        $this->assertCount(5, $event->interested_attendees);
    }

    /*
        testCreateEventWithComments() - Test that the application can create an event with 10 comments.
        Check that the comments exist as we create them. The event->comments should exist and their count should match the number of comments we create.
    */
    public function testCreateEventWithComments(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        $event = Event::factory()->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ]);

        Comment::factory()->count(10)->create([
            'user_id' => $member->id,
            'commentable_id' => $event->id,
            'commentable_type' => Event::class
        ])->each(function($comment) use ($event,$member){
            $this->assertDatabaseHas('comments', [
                'id' => $comment->id,
                'commentable_id' => $event->id,
                'commentable_type' => Event::class,
                'user_id' => $member->id
            ]);
        });

        $this->assertIsObject($event->comments);
        $this->assertCount(10, $event->comments);
    }

    /*
        testUpdateEvent() - Test that the application can update an event model and database record.
        Create a group, member, and event using that group and member.
        Check that the model properties and accessor attributes were updated properly.
    */

    public function testUpdateEvent(){

        $group = Group::factory()->create();
        $member = User::factory()->create();
        $updater = User::factory()->create();
        $group->users()->attach($member->id);

        $event = Event::factory()->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ]);

        $new_header_url = FileHelper::getRandomImageFromDirectory('default_headers','events');
        $updated_event = [
            'name' => 'New Name',
            'location_name' => 'New Location',
            'location_formatted_address' => 'New Address St.',
            'location_city' => 'New York City',
            'location_state' => 'NY',
            'description' => 'This is an updated description',
            'start_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => '14:30',
            'end_date' => Carbon::today()->addDays(2)->format('Y-m-d'),
            'end_time' => '16:30',
            'header_url' => $new_header_url,
            'updater_id' => $updater->id
        ];

        // we need to delay the update by 1 second so that the created_at and updated_at timestamps will be different
        sleep(1);
        $event->update($updated_event);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'group_id' => $group->id,
            'creator_id' => $member->id,
            'updater_id' => $updater->id
        ]);

        $this->assertEquals($updated_event['name'], $event->name);
        $this->assertEquals($updated_event['location_name'], $event->location_name);
        $this->assertEquals($updated_event['location_formatted_address'], $event->location_formatted_address);
        $this->assertEquals($updated_event['location_city'], $event->location_city);
        $this->assertEquals($updated_event['location_state'], $event->location_state);
        $this->assertEquals($updated_event['description'], $event->description);
        $this->assertEquals($updated_event['start_date'], $event->start_date->format('Y-m-d'));
        $this->assertEquals($updated_event['start_time'], $event->start_time);
        $this->assertEquals($updated_event['end_date'], $event->end_date->format('Y-m-d'));
        $this->assertEquals($updated_event['end_time'], $event->end_time);
        $this->assertEquals($updated_event['header_url'], $event->header_url);

        Storage::disk('public')->assertExists('events/'.$event->header_url);

        $this->assertIsObject($event->updater);
        $this->assertEquals($updater->id,$event->updater->id);

        // edited should be true now that we have updated the comment and waited 1 second
        $this->assertIsBool($event->edited);
        $this->assertTrue($event->edited);
    }
}
