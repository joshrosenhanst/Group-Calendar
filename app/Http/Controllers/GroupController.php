<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use JavaScript;
use App\Notifications\MemberLeftGroupMessage;
use App\Notifications\MemberLeft;
use App\Notifications\GroupCommentCreated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\FileHelper;

class GroupController extends Controller{
  /*
    index() - Display the `groups.list` page template.
  */
  public function index() {
    return view('groups.index', ['groups'=>Auth::user()->groups]);
  }

  /*
    new() - Display the `groups.new` page template.
  */
  public function new(){
    $filehelper = new FileHelper;

    $header_images = $filehelper->getImagesInDirectory('default_headers', "Preview Header");
    $avatar_images = $filehelper->getImagesInDirectory('default_avatars', "Preview Avatar");
    return view('groups.new', ['header_images'=>$header_images, 'avatar_images'=>$avatar_images]);
  }

  /*
    edit() - Display the `groups.edit` page template.
  */
  public function edit(\App\Group $group){
    $filehelper = new FileHelper;

    $header_images = $filehelper->getImagesInDirectory('default_headers', "Preview Header");
    $avatar_images = $filehelper->getImagesInDirectory('default_avatars', "Preview Avatar");
    return view('groups.edit', ['group'=>$group,'header_images'=>$header_images, 'avatar_images'=>$avatar_images]);
  }

  /*
    events() - Display the `groups.events` page template.
  */
  public function events(\App\Group $group) {
    $monthly_upcoming_events = $group->getMonthlyUpcomingEvents();
    $monthly_past_events = $group->getMonthlyPastEvents();

    return view('groups.events', [
      'group'=>$group,
      'monthly_upcoming_events' => $monthly_upcoming_events,
      'monthly_past_events' => $monthly_past_events
    ]);
  }

  /*
    view() - Display the `groups.home` page template.
  */
  public function view(\App\Group $group) {
    $group->loadMissing(['comments.user','users' => function($query){
      $query->limit(5);
    }]);
    $upcoming_events = $group->getUpcomingEvents();

    JavaScript::put([
      'data' => [
        'user' => Auth::user(),
        'group' => $group,
        'comments' => $group->comments
      ]
    ]);

    return view('groups.view', [
      'group' => $group,
      'events' => $upcoming_events
    ]);
  }

  /*
    members() - Display the `groups.members` page template.
  */
  public function members(\App\Group $group) {
    $group->loadMissing(['users','group_invites']);

    JavaScript::put([
      'data' => [
        'group' => $group,
        'members' => $group->users,
        'invited' => $group->group_invites
      ]
    ]);

    return view('groups.members', [
      'group' => $group,
    ]);
  }

  public function create(Request $request){
    $filehelper = new FileHelper;

    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255|unique:groups,name',
      'header_url' => 'nullable|string',
      'avatar_url' => 'nullable|string'
    ]);

    $validator->validate();

    if($request->header_url){
      $filehelper->copyDefaultImage($request->header_url, 'default_headers', 'groups');
    }

    if($request->avatar_url){
      $filehelper->copyDefaultImage($request->avatar_url, 'default_avatars', 'avatars');
    }

    $group = \App\Group::create([
      'name' => $request->name,
      'header_url' => $request->header_url,
      'avatar_url' => $request->avatar_url
    ]);
    $group->users()->attach(Auth::user()->id, [
      'role' => 'admin'
    ]);

    return redirect()->route('groups.view', ['group'=>$group])->with('status', 'The group has been created. You have been added as an admin. You can now invite other members to the group.');
  }

  public function update(Request $request, \App\Group $group){
    $filehelper = new FileHelper;

    $validator = Validator::make($request->all(), [
      'name' => [
        'required','string','max:255',Rule::unique('groups','name')->ignore($group->id)
      ],
      'header_url' => 'nullable|string',
      'avatar_url' => 'nullable|string'
    ]);

    $validator->validate();

    if($request->header_url && $request->header_url !== $group->header_url){
      $filehelper->copyDefaultImage($request->header_url, 'default_headers', 'groups');
    }

    if($request->avatar_url && $request->avatar_url !== $group->avatar_url){
      $filehelper->copyDefaultImage($request->avatar_url, 'default_avatars', 'avatars');
    }

    $group->update([
      'name' => $request->name,
      'header_url' => $request->header_url,
      'avatar_url' => $request->avatar_url
    ]);

    if($request->update_comment){
      $group->comments()->create([
        'text' => $request->update_comment,
        'user_id' => Auth::user()->id
      ]);
      // notify the group that a comment has been posted
      $group->notify(new GroupCommentCreated(Auth::user(), $group, $request->update_comment));
    }

    return redirect()->route('groups.view', ['group'=>$group])->with('status','The group has been updated.');
  }

  /*
    leave() - Display the `groups.leave` page template.
  */
  public function leave(\App\Group $group){
    return view('groups.leave', ['group'=>$group]);
  }

  public function leaveGroup(Request $request, \App\Group $group){
    $group->users()->detach(Auth::user()->id);

    // notify the group the user has left
    $group->notify(new MemberLeftGroupMessage(Auth::user(), $group));
    // notify the user they left
    Auth::user()->notify(new MemberLeft(Auth::user(), $group));

    return redirect()->route('home')->with('status','You have left the group.');
  }

  /*
    createComment() - Add a group comment submitted by the new comment form on the groups.view page.
  */
  public function createComment(Request $request, \App\Group $group){
    $request->validate([
      'comment_text'=>'required'
    ]);

    $comment = $group->comments()->create([
      'text' => $request->comment_text,
      'user_id' => Auth::user()->id
    ]);

    $group->notify(new GroupCommentCreated(Auth::user(), $group, $request->comment_text));
    return redirect()->route('groups.view', ['group'=>$group])->with('status', 'Your comment has been posted.');
  }
}
