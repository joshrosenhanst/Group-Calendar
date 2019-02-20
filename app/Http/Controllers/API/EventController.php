<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
  /*
    index() - Return all events, optionally filtered by group
  */
  public function index($group=null){
    $events = Event::all();
    return response()->json($events);
  }

  public function view(\App\Event $event){
    return response()->json($event);
  }
}
