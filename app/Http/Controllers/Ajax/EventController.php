<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
  /*
    attend() - Set or update a user's attendance status for an event.
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
    //trigger "event attendee updated" Event
    return response()->json($new_status);
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
    //trigger "comment created" Event
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