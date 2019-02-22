<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
  /*
    createComment() - Create a group comment. Return the group comments.
  */
  public function createComment(Request $request, \App\Group $group){
    $request->validate([
      'text'=>'required',
      'user_id'=>'required|numeric|exists:users,id'
    ]);

    $comment = $group->comments()->create([
      'text' => $request->text,
      'user_id' => $request->user_id
    ]);
    //trigger "comment created" Event
    $group->loadMissing('comments.user');
    return response()->json($group->comments);
  }

  /*
    updateComment() - Update an event comment. Return the event comments.
  */
  public function updateComment(Request $request, \App\Group $group, \App\Comment $comment){
    $request->validate([
      'text'=>'required'
    ]);

    $comment->update([
      'text' => $request->text
    ]);

    //trigger "comment updated" Event
    $group->loadMissing('comments.user');
    return response()->json($group->comments);
  }
  
  /*
    destroyComment() - Delete an event comment. Return the event comments.
  */
  public function destroyComment(Request $request, \App\Group $group, \App\Comment $comment){

    $comment->delete();

    //trigger "comment deleted" Event
    $group->loadMissing('comments.user');
    return response()->json($group->comments);
  }
}
