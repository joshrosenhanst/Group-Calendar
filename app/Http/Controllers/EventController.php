<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventCreated;
use App\Notifications\EventUpdated;
use App\Notifications\EventDeleted;
use App\Notifications\EventCommentCreated;
use JavaScript;
use Illuminate\Support\Carbon;
use Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /*
      index() - Display the `events.index` page template.
    */
    public function index(){
      return view('events.index');
    }
    
    /*
      calendar() - Display the `events.calendar` page template.
    */
    public function calendar(){
      return view('events.calendar');
    }

    /*
      new() - Display the `events.new` page template.
    */
    public function new(Request $request, \App\Group $group = null){
      $events = Auth::user()->getEventsForDatepicker();
      JavaScript::put([
        'data' => [
          'showEndDate' => ( old('end_date')?true:false ),
          'events' => $events,
        ]
      ]);
      return view('events.new', ['group'=>$group]);
    }

    /*
      create() - Validate the fields submitted on the `events.new` form. If valid, create a new event in the database.
    */
    public function create(Request $request){
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'group' => 'required|numeric|exists:groups,id',
        'start_date' => 'required|date',
        'start_time' => 'nullable|date_format:H:i',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'end_time' => 'nullable|date_format:H:i'
      ]);

      $validator->after(function($validator) use ($request){
        if($request->end_date && $request->end_time && $request->start_time && $request->start_date){
          if(strtotime($request->end_date." ".$request->end_time) < strtotime($request->start_date." ".$request->start_time)){
            $validator->errors()->add('end_time', 'The end time must be after start time.');
          }
        }
      });

      $validator->validate();

      $start_date = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : null;
      $end_date =  $request->end_date ? Carbon::parse($request->end_date)->toDateString(): null;

      $event = \App\Event::create([
        'name' => $request->name,
        'header_url' => $request->header_url,
        'creator_id' => Auth::user()->id,
        'group_id' => $request->group,
        'description' => $request->description,
        'start_date' => $start_date,
        'start_time' => $request->start_time,
        'end_date' => $end_date,
        'end_time' => $request->end_time
      ]);

      $group = \App\Group::find($request->group);

      //trigger "event created" Event
      // notify the group that an event was created
      $group->notify(new EventCreated(Auth::user(), $event, $group));

      return redirect()->route('groups.events.view', ['event'=>$event, 'group'=>$group])->with('status', 'Your event has been created.');
    }

    /*
      event_redirect() - Redirect the user to the full groups.events.view path.
    */
    public function event_redirect(\App\Event $event){
      return redirect()->route('groups.events.view', ['event'=>$event,'group'=>$event->group]);
    }

    /*
      view() - Display the `events.view` page template.
    */
    public function view(\App\Group $group, \App\Event $event){
      $event->loadMissing(['comments.user','attendees']);
      JavaScript::put([
        'data' => [
          'user' => Auth::user(),
          'event' => $event->makeHidden('comments')->toArray(),
          'comments' => $event->comments
        ]
      ]);

      return view('events.view', ['event'=>$event]);
    }

    /*
      edit() - Display the `events.edit` page template.
    */
    public function edit(\App\Group $group, \App\Event $event){
      $events = Auth::user()->getEventsForDatepicker();
      JavaScript::put([
        'data' => [
          'showEndDate' => ( old('end_date',$event->end_date)?true:false ),
          'events' => $events,
        ]
      ]);
      return view('events.edit', ['event'=>$event]);
    }

    /*
      update() - Validate the fields submitted on the `events.edit` form. If valid, update the event model in the database.
    */
    public function update(Request $request, \App\Event $event){
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'start_date' => 'required|date',
        'start_time' => 'nullable|date_format:H:i',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'end_time' => 'nullable|date_format:H:i',
      ]);

      $validator->after(function($validator) use ($request){
        if($request->end_date && $request->end_time && $request->start_time && $request->start_date){
          if(strtotime($request->end_date." ".$request->end_time) < strtotime($request->start_date." ".$request->start_time)){
            $validator->errors()->add('end_time', 'The end time must be after start time.');
          }
        }
      });

      $validator->validate();

      $start_date = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : null;
      $end_date =  $request->end_date ? Carbon::parse($request->end_date)->toDateString(): null;

      $event->update([
        'name' => $request->name,
        'header_url' => $request->header_url,
        'updater_id' => Auth::user()->id,
        'description' => $request->description,
        'start_date' => $start_date,
        'start_time' => $request->start_time,
        'end_date' => $end_date,
        'end_time' => $request->end_time
      ]);

      //trigger "event updated" Event
      // notify the group that an event was updated
      $event->group->notify(new EventUpdated(Auth::user(), $event));

      if($request->update_comment){
        $event->comments()->create([
          'text' => $request->update_comment,
          'user_id' => Auth::user()->id
        ]);
        // notify the group that a comment has been posted
        $event->group->notify(new EventCommentCreated(Auth::user(), $event, $request->update_comment));
      }

      return redirect()->route('groups.events.view', ['event'=>$event, 'group'=>$event->group])->with('status', 'The event has been updated.');
    }

    /*
      attend() - Add the Auth::user as an attendee for the event, set their pivot status to the $request->status.
    */
    public function attend(Request $request, \App\Event $event){
      $attendee = $event->attendees()->where('user_id',Auth::user()->id)->first();
      if($attendee){
        $event->attendees()->updateExistingPivot(Auth::user()->id,[
          'status' => $request->input('status', 'pending')
        ]);
      }else{
        $event->attendees()->attach(Auth::user()->id, [
          'status' => $request->input('status', 'pending')
        ]);
      }

      //trigger "event attendee updated" Event

      return redirect()->route('groups.events.view', ['event'=>$event, 'group'=>$event->group])->with('status', 'Your attendee status has been updated.');
    }

    /*
      delete() - Display the `events.delete` page template.
    */
    public function delete(\App\Group $group, \App\Event $event){
      return view('events.delete', ['event'=>$event]);
    }

    /*
      destroy() - Delete the event model from the database.
    */
    public function destroy(Request $request, \App\Event $event){
      $group = $event->group;
      $event_copy = $event;
      $event->delete();

      //trigger "event deleted" Event
      $group->notify(new EventDeleted(Auth::user(), $event_copy));

      return redirect()->route('groups.events.index', ['group'=>$group])->with('status', 'The event has been deleted.');
    }
}
