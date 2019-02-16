<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(){
      return view('events.index');
    }

    public function new(){
      return view('events.new');
    }

    public function create(Request $request){
      $request->validate([
        'name' => 'required',
        'group' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date'
      ]);

      $event = \App\Event::create([
        'name' => $request->name,
        'header_url' => $request->header_url,
        'creator_id' => Auth::user()->id,
        'group_id' => $request->group,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'start_time' => $request->start_time,
        'end_date' => $request->end_date,
        'end_time' => $request->end_time
      ]);

      return redirect()->route('events.view', ['event'=>$event])->with('status', 'Your event has been created.');
    }

    public function view(\App\Event $event){
      return view('events.view', ['event'=>$event]);
    }
}
