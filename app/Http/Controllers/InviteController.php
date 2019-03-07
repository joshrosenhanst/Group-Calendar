<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Notifications\UserInvited;
use App\Notifications\NewUserInvited;
use App\Notifications\UserInvitedGroupMessage;
use App\Notifications\UserJoined;
use App\Notifications\UserDeclined;

class InviteController extends Controller
{
  /*
    invite() - Display the `groups.invite` view.
  */
  public function invite(\App\Group $group){
    return view('groups.invite', ['group'=>$group]);
  }

  /*
    createInvite() - Create a GroupInvite for a group and a user.
    - Validate the name and email fields.
    - Check if the user exists via email address.
      - If they exist, check that they aren't already in the group, return error status. If not, create a GroupInvite, notify the user and notify the group. Return to `groups.members` with a status that the user has been invited.
      - If they don't exist, create a new user account with `account_setup` set to false, send them an email with a `joinGroup` link including a checksum, notify the new user and the group. Return to `groups.members` with a status that the user has been invited.
  */
  public function createInvite(Request $request, \App\Group $group){
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|email'
    ]);

    $validator->validate();

    $user = \App\User::where("email",$request->email)->first();
    if($user){

      if($group->users()->where('user_id',$user->id)->exists()){

        return redirect()->route('groups.invites', ['group'=>$group])->withErrors([
          'email' => 'The user is already a member of the group.'
        ])->withInput();

      }else{

        $group->group_invites()->attach($user->id, [
          'creator_id' => Auth::user()->id
        ]);

        // notify the user
        $user->notify(new UserInvited($user,$group,Auth::user()));

        // notify the group
        $group->notify(new UserInvitedGroupMessage($user,$group));

        return redirect()->route('groups.members',['group'=>$group])->with('status', 'The user has been invited to the group.');

      }

    }else{

      $user = \App\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'account_setup' => false
      ]);

      $group->group_invites()->attach($user->id, [
        'creator_id' => Auth::user()->id
      ]);

      // notify the user and send them a checksum email link
      $user->notify(new NewUserInvited($user,$group,Auth::user()));

      // notify the group
      $group->notify(new UserInvitedGroupMessage($user,$group));

      return redirect()->route('groups.members',['group'=>$group])->with('status', 'The user has been invited to the group.');

    }
  }

  /*
    join() - Check if the auth::user() has been invited to the group, then display the `groups.join` view.
  */
  public function join(\App\Group $group){
    if($group->group_invites()->where('user_id',Auth::user()->id)->exists()){
      return view('groups.join', ['group'=>$group]);
    }else{
      if($group->users()->where('user_id',Auth::user()->id)->exists()){
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You are already a member of this group.');
      }else{
        return redirect()->route('home')->with('status', 'You can not join that group because you have not been invited.');
      }
    }
  }

  /*
    decline() - Check if the auth::user() has been invited to the group, then display the `groups.decline` view.
  */
  public function decline(\App\Group $group){
    if($group->group_invites()->where('user_id',Auth::user()->id)->exists()){
      return view('groups.decline', ['group'=>$group]);
    }else{
      if($group->users()->where('user_id',Auth::user()->id)->exists()){
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You are already a member of this group.');
      }else{
        return redirect()->route('home')->with('status', 'You can not decline the group invitation because you have not been invited.');
      }
    }
  }

  /*
    acceptInvite() - Check if the user's group_invite exists:
      - If it does, add them to the group as a member and delete the group_invite record. Notify the group. Redirect the user to the `group.view` page.
      - If it doesn't exist, check if they are already a member and send them to the `group.view page, if they're not a member send them to `home`.
  */
  public function acceptInvite(Request $request, \App\Group $group){

  }
}
