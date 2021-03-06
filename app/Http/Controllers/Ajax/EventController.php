<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EventCommentCreated;

class EventController extends Controller
{
  /*
    getEvent() - Return an array with the event model details and comments.
  */
  public function getEvent(Request $request, \App\Event $event){
    $event->loadMissing(['comments.user','attendees']);
    return response()->json([
      'event' => $event->makeHidden('comments')->toArray(),
      'comments' => $event->comments
    ]);
  }

  /*
    attend() - Set or update a user's attendance status for an event. Return an array of attendance information:
    - user_status: the user's attendance status
    - going_attendees_count: number of attendees marked as `going`,
    - interested_attendees_count: number of attendees marked as `interested`,
    - attendees: array of attendees

  */
  public function attend(Request $request, \App\Event $event){
    $request->validate([
      'status'=>'required|in:pending,interested,going,unavailable',
      'user_id'=>'required|numeric|exists:users,id'
    ]);

    $new_status = $request->input('status', 'pending');
    $user = $request->user_id;

    $attendee = $event->attendees()->where('user_id',$user)->first();
    if($attendee){
      $event->attendees()->updateExistingPivot($user,[
        'status' => $new_status
      ]);
    }else{
      $event->attendees()->attach($user, [
        'status' => $new_status
      ]);
    }
    $event->refresh();
    $event->loadMissing(['comments.user','attendees']);
    //trigger "event attendee updated" Event
    return response()->json([
      'event' => $event->makeHidden('comments')->toArray(),
      'comments' => $event->comments
    ]);
  }

  /*
    createComment() - Create an event comment. Return the event comments.
  */
  public function createComment(Request $request, \App\Event $event){
    $request->validate([
      'text'=>'required',
      'user_id'=>'required|numeric|exists:users,id'
    ]);

    $comment = $event->comments()->create([
      'text' => $request->text,
      'user_id' => $request->user_id
    ]);

    $user = \App\User::find($request->user_id);

    // notify the group that a comment has been posted
    $event->group->notify(new EventCommentCreated($user, $event, $request->text));
    
    $event->loadMissing('comments.user');
    return response()->json($event->comments);
  }

  /*
    updateComment() - Update an event comment. Return the event comments.
  */
  public function updateComment(Request $request, \App\Event $event, \App\Comment $comment){
    $request->validate([
      'text'=>'required'
    ]);

    $comment->update([
      'text' => $request->text
    ]);

    //trigger "comment updated" Event
    $event->loadMissing('comments.user');
    return response()->json($event->comments);
  }
  
  /*
    destroyComment() - Delete an event comment. Return the event comments.
  */
  public function destroyComment(\App\Event $event, \App\Comment $comment){

    $comment->delete();

    //trigger "comment deleted" Event
    $event->loadMissing('comments.user');
    return response()->json($event->comments);
  }
}
