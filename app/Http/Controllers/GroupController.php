<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller{
  /*
    index() - Display the `groups.list` page template.
  */
  public function index() {
    $groups = Auth::user()->groups()->get();
    return view('groups.index', ['groups'=>$groups]);
  }

  /*
    view() - Display the `groups.home` page template.
  */
  public function view(\App\Group $group) {
    $group->loadMissing(['users','comments.user']);
    $upcoming_events = $group->getUpcomingEvents();
    return view('groups.view', [
      'group' => $group,
      'events' => $upcoming_events
    ]);
  }

  /*
    members() - Display the `groups.members` page template.
  */
  public function members(\App\Group $group) {
    $group->loadMissing(['users']);
    return view('groups.members', [
      'group' => $group,
    ]);
  }
}
