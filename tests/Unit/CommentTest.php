<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Group;
use App\User;
use App\Event;
use App\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /*
        testCreateGroupComments() - Test that the application create a group comment model and database record.
        The test should create a new group, member, and a comment using the group and member. 
        Check that the comment values are set properly and that the model accessor attributes are initialized.
    */
    public function testCreateGroupComments(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        $comment_text = $this->faker->realText(150);

        $comment = Comment::factory()->create([
            'text' => $comment_text,
            'user_id' => $member->id,
            'commentable_id' => $group->id,
            'commentable_type' => \App\Group::class
        ]);

        $this->assertInstanceOf(\App\Comment::class, $comment);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'commentable_id' => $group->id,
            'commentable_type' => \App\Group::class,
            'user_id' => $member->id
        ]);
        $this->assertEquals($comment_text, $comment->text);

        $this->assertIsObject($comment->user);
        $this->assertEquals($member->id,$comment->user->id);

        $this->assertIsString($comment->created_text);
        $this->assertEquals($comment->created_text, $comment->created_at->diffForHumans());
    
        // updated_at timestamp is set on creation, so updated_text should exist
        $this->assertIsString($comment->updated_text);
        $this->assertEquals($comment->updated_text, $comment->updated_at->diffForHumans());

        // edited should be false because we havent updated the comment
        $this->assertIsBool($comment->edited);
        $this->assertFalse($comment->edited);
    }

    /*
        testCreate() - Test that the application create an event comment model and database record.
        The test should create a new group, member, event and a comment using the event and member. 
        Check that the comment values are set properly and that the model accessor attributes are initialized.
    */
    public function testCreateEventComments(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);
        $event = Event::factory()->create([
            'group_id' => $group->id,
            'creator_id' => $member->id
        ]);

        $comment_text = $this->faker->realText(150);

        $comment = Comment::factory()->create([
            'text' => $comment_text,
            'user_id' => $member->id,
            'commentable_id' => $event->id,
            'commentable_type' => \App\Event::class
        ]);

        $this->assertInstanceOf(\App\Comment::class, $comment);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'commentable_id' => $event->id,
            'commentable_type' => \App\Event::class,
            'user_id' => $member->id
        ]);
        $this->assertEquals($comment_text, $comment->text);

        $this->assertIsObject($comment->user);
        $this->assertEquals($member->id,$comment->user->id);

        $this->assertIsString($comment->created_text);
        $this->assertEquals($comment->created_text, $comment->created_at->diffForHumans());
    
        // updated_at timestamp is set on creation, so updated_text should exist
        $this->assertIsString($comment->updated_text);
        $this->assertEquals($comment->updated_text, $comment->updated_at->diffForHumans());

        // edited should be false because we havent updated the comment
        $this->assertIsBool($comment->edited);
        $this->assertFalse($comment->edited);
    }

    /*
        testUpdateComment() - Test that the application can update a comment model and database record.
        Create a group, member, and comment using the group and member.
        Check that the model properties and accessor attributes were updated properly.
    */
    public function testUpdateComment(){
        $group = Group::factory()->create();
        $member = User::factory()->create();
        $group->users()->attach($member->id);

        $comment = Comment::factory()->create([
            'text' => "Initial Comment",
            'user_id' => $member->id,
            'commentable_id' => $group->id,
            'commentable_type' => Group::class
        ]);

        $updated_text = $this->faker->realText(150);

        //we need to delay the update by 1 second so that the created_at and updated_at timestamps will be different
        sleep(1);
        $comment->update([
            'text' => $updated_text
        ]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'commentable_id' => $group->id,
            'commentable_type' => Group::class,
            'user_id' => $member->id
        ]);
        $this->assertEquals($updated_text, $comment->text);

        $this->assertIsObject($comment->user);
        $this->assertEquals($member->id,$comment->user->id);

        $this->assertIsString($comment->created_text);
        $this->assertEquals($comment->created_text, $comment->created_at->diffForHumans());
    
        $this->assertIsString($comment->updated_text);
        $this->assertEquals($comment->updated_text, $comment->updated_at->diffForHumans());

        // edited should be true now that we have updated the comment and waited 1 second
        $this->assertIsBool($comment->edited);
        $this->assertTrue($comment->edited);
    }
}
