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
      'user_id'=>'required|numeric'
    ]);

    $new_status = $request->input('status', 'pending');
    $user = $request->user;

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
}
