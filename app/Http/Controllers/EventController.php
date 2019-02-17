<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /*
      index() - Display the `events.index` page template.
    */
    public function index(){
      return view('events.index');
    }

    /*
      new() - Display the `events.new` page template.
    */
    public function new(){
      return view('events.new');
    }

    /*
      create() - Validate the fields submitted on the `events.new` form. If valid, create a new event in the database.
    */
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

      //trigger "event created" Event

      return redirect()->route('events.view', ['event'=>$event])->with('status', 'Your event has been created.');
    }

    /*
      view() - Display the `events.view` page template.
    */
    public function view(\App\Event $event){
      return view('events.view', ['event'=>$event]);
    }

    /*
      edit() - Display the `events.edit` page template.
    */
    public function edit(\App\Event $event){
      return view('events.edit', ['event'=>$event]);
    }

    /*
      update() - Validate the fields submitted on the `events.edit` form. If valid, update the event model in the database.
    */
    public function update(Request $request, \App\Event $event){
      $request->validate([
        'name' => 'required',
        'group' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date'
      ]);

      $event->update([
        'name' => $request->name,
        'header_url' => $request->header_url,
        'group_id' => $request->group,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'start_time' => $request->start_time,
        'end_date' => $request->end_date,
        'end_time' => $request->end_time
      ]);

      //trigger "event updated" Event

      return redirect()->route('events.view', ['event'=>$event])->with('status', 'The event has been updated.');
    }

    /*
      delete() - Display the `events.delete` page template.
    */
    public function delete(\App\Event $event){
      return view('events.delete', ['event'=>$event]);
    }

    /*
      destroy() - Delete the event model from the database.
    */
    public function destroy(Request $request, \App\Event $event){
      $event->delete();

      //trigger "event deleted" Event

      return redirect()->route('events.index')->with('status', 'The event has been deleted.');
    }
}
