<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
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
      'email' => 'required|email|max:255'
    ]);

    $validator->validate();

    $user = \App\User::where("email",$request->email)->first();
    if($user){

      if($group->users()->where('user_id',$user->id)->exists()){

        return redirect()->route('groups.invite', ['group'=>$group])->withErrors([
          'email' => 'The user is already a member of the group.'
        ])->withInput();

      }else{

        if($group->group_invites()->where('user_id',$user->id)->exists()){
          return redirect()->route('groups.invite', ['group'=>$group])->withErrors([
            'email' => 'The user has already been invited.'
          ])->withInput();
        }else{
          $group->group_invites()->attach($user->id, [
            'creator_id' => Auth::user()->id,
            'token' => Str::uuid()
          ]);

          // notify the user
          $user->notify(new UserInvited($user,$group,Auth::user()));

          // notify the group
          $group->notify(new UserInvitedGroupMessage($user,$group,Auth::user()));

          return redirect()->route('groups.members',['group'=>$group])->with('status', 'The user has been invited to the group.');
        }

      }

    }else{

      $user = \App\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'account_setup' => false
      ]);

      $invite = $group->group_invites()->attach($user->id, [
        'creator_id' => Auth::user()->id,
        'token' => Str::uuid()
      ]);

      // notify the user and send them a checksum email link
      $user->notify(new NewUserInvited($invite,$user,$group,Auth::user()));

      // notify the group
      $group->notify(new UserInvitedGroupMessage($user,$group));

      return redirect()->route('groups.members',['group'=>$group])->with('status', 'The user has been invited to the group.');

    }
  }

  /*
    join() - Check if the auth::user() has been invited to the group, then display the `groups.invites.join` view.
  */
  public function join(\App\Group $group){
    $invite = $group->group_invites()->where('user_id',Auth::user()->id)->first();
    if($invite){
      $creator = User::find($invite->creator_id);
      return view('groups.invites.join', ['group'=>$group,'creator'=>$creator]);
    }else{
      if($group->users()->where('user_id',Auth::user()->id)->exists()){
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You are already a member of this group.');
      }else{
        return redirect()->route('home')->with('status', 'You can not join that group because you have not been invited.');
      }
    }
  }

  /*
    decline() - Check if the auth::user() has been invited to the group, then display the `groups.invites.decline` view.
  */
  public function decline(\App\Group $group){
    if($group->group_invites()->where('user_id',Auth::user()->id)->exists()){
      return view('groups.invites.decline', ['group'=>$group]);
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
    $invite = $group->group_invites()->where('user_id',Auth::user()->id)->first();

    if($invite){

      $group->users()->attach(Auth::user()->id);
      $group->group_invites()->detach($invite->id);

      // notify the group
      $group->notify(new UserJoined(Auth::user(),$group));
      return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You have joined the group. You can now attend and create events in the group.');

    }else{

      if($group->users()->where('user_id',Auth::user()->id)->exists()){
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You are already a member of this group.');
      }else{
        return redirect()->route('home')->with('status', 'You can not accept the group invitation because you have not been invited.');
      }

    }

  }

  /*
    declineInvite() - Check if the user's group_invite exists:
      - If it does, delete the group_invite record. Notify the group. Redirect the user to the `home` page.
      - If it doesn't exist, check if they are already a member and send them to the `group.view page, if they're not a member send them to `home`.
  */
  public function declineInvite(Request $request, \App\Group $group){
    $invite = $group->group_invites()->where('user_id',Auth::user()->id)->first();

    if($invite){

      $group->group_invites()->detach($invite->id);

      // notify the group
      $group->notify(new UserDeclined(Auth::user(),$group));
      return redirect()->route('groups.view')->with('status', 'You have declined the invitation from the group.');

    }else{

      if($group->users()->where('user_id',Auth::user()->id)->exists()){
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'You are already a member of this group. If you want to leave the group you can use the Leave Group link.');
      }else{
        return redirect()->route('home')->with('status', 'You can not decline the group invitation because you have not been invited.');
      }

    }

  }

  /*
    register() - Allow a new user to register and join the group. Display the `register` view if the provided $request->token is valid.
  */
  public function register(Request $request){
    if($request->token){
      $invite = \App\GroupInvites::where('token', $request->token)->first();
      if($invite){
        $user = \App\User::find($invite->user_id);
        $group = \App\Group::find($invite->group_id);
        $creator = \App\User::find($invite->creator_id);

        return view('register', ['user'=>$user,'group'=>$group,'creator'=>$creator, 'token'=>$invite->token]);
      }else{
        return redirect()->route('login')->with('status', 'Invalid token provided. Please click the link in the group invitation email.');
      }
    }else{
      return redirect()->route('login')->with('status', 'Invalid token provided. Please click the link in the group invitation email.');
    }
  }

  /*
    submitRegistration() - Check that the token is valid and exists. Validate the name, email and password fields. Then update the temp user account and set `account_setup` to true. Add the user to the group as a member and delete the GroupInvite record. Redirect to the `groups.view` page.
  */
  public function submitRegistration(Request $request){
    if($request->token){

      $invite = \App\GroupInvites::where('token', $request->token)->first();
      if($invite){
        $user = \App\User::find($invite->user_id);
        $group = \App\Group::find($invite->group_id);
        $creator = \App\User::find($invite->creator_id);

        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'email' => [
            'required','email','max:255',Rule::unique('users')->ignore($user->id)
          ],
          'password' => 'required|string|min:6|max:255|confirmed',
          'password_confirmation' => 'required|string|max:255'
        ]);
        $validator->validate();

        $user->update([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'account_setup' => true
        ]);
        $group->users()->attach($user->id);
        $group->group_invites()->detach($invite->id);

        // log the user in
        Auth::login($user);

        // notify group
        $group->notify(new UserJoined($user,$group));
        return redirect()->route('groups.view', ['group'=>$group])->with('status', 'Your account has been registered and you have been logged in. You have joined the group. You can now attend and create events in the group.');
      }else{
        return redirect()->route('login')->with('status', 'Invalid token provided. Please click the link in the group invitation email. If you have already accepted the group invitation and completed the New User Registration form, you can log into your account.');
      }
  
    }else{
      return redirect()->route('login')->with('status', 'Invalid token provided. Please click the link in the group invitation email.');
    }
  }
}
