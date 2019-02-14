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
    $group->loadMissing('users');
    $upcoming_events = $group->getUpcomingEvents();
    $latest_comments = $group->getLatestComments();
    $latest_comments->loadMissing('user');
    return view('groups.view', [
      'group' => $group,
      'events' => $upcoming_events,
      'comments' => $latest_comments
    ]);
  }
}
