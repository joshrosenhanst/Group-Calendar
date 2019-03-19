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
    updateComment() - Update a group comment. Return the group comments.
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
    destroyComment() - Delete a group comment. Return the group comments.
  */
  public function destroyComment(Request $request, \App\Group $group, \App\Comment $comment){

    $comment->delete();

    //trigger "comment deleted" Event
    $group->loadMissing('comments.user');
    return response()->json($group->comments);
  }

  /*
    updateMember() - Update a member's status. Return the group members.
  */
  public function updateMember(Request $request, \App\Group $group){
    $request->validate([
      'role'=>'required|in:member,admin',
      'user_id'=>'required|exists:group_user'
    ]);

    $member = $group->users()->where('user_id',$request->user_id)->first();
    if($member){
      $group->users()->updateExistingPivot($member, [
        'role'=>$request->role
      ]);
      //trigger "member role updated" Event
      return response()->json([
        'members' => $group->users()->get(),
        'invited' => $group->group_invites()->get()
      ]);
    }else{
      return response()->json([
        'errors'=>[
          'user_id'=>['Member not found.']
        ]
      ], 422);
    }
  }

  /*
    removeMember() - Detach a user from the group. Return the group members.
  */
  public function removeMember(Request $request, \App\Group $group){
    $request->validate([
      'user_id'=>'required|exists:group_user'
    ]);

    $group->users()->detach($request->user_id);

    //trigger "member removed" Event
    return response()->json([
      'members' => $group->users()->get(),
      'invited' => $group->group_invites()->get()
    ]);
  }
}
