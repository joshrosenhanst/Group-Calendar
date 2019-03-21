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
use App\FileHelper;
use PDF;
use Illuminate\Support\Str;
use App\Jobs\GenerateEventFlyer;

class EventController extends Controller
{
  public function flyer(\App\Group $group, \App\Event $event){
    return view('events.flyer', ['event'=>$event]);
  }

  /*
    index() - Display the `events.index` page template.
  */
  public function index(){
    Auth::user()->loadMissing('groups.upcoming_events.auth_user_status');
    Auth::user()->loadMissing('groups.past_events.auth_user_status');
    
    $monthly_upcoming_events = Auth::user()->upcoming_events->groupBy(function($event){
      return $event->start_date->format('F Y');
    });
    $monthly_past_events = Auth::user()->past_events->groupBy(function($event){
      return $event->start_date->format('F Y');
    });
    
    return view('events.index', [
      'monthly_upcoming_events' => $monthly_upcoming_events,
      'monthly_past_events' => $monthly_past_events
    ]);
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
    $filehelper = new FileHelper;

    $events = Auth::user()->getEventsForDatepicker();
    $header_images = $filehelper->getImagesInDirectory('default_headers', "Preview Header");
    JavaScript::put([
      'data' => [
        'showEndDate' => ( old('end_date')?true:false ),
        'events' => count($events) ? $events : (object) null, // AppDatepicker expects an object so we can't pass an empty php array
        'selected_location' => old('location'),
      ]
    ]);
    return view('events.new', ['group'=>$group, 'header_images'=>$header_images]);
  }

  /*
    create() - Validate the fields submitted on the `events.new` form. If valid, create a new event in the database.
  */
  public function create(Request $request){
    $filehelper = new FileHelper;

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'group' => 'required|numeric|exists:groups,id',
      'start_date' => 'required|date',
      'start_time' => [
        'nullable','string', function($attribute, $value, $fail){
          if(!strtotime($value)){
            $fail("The start time field is invalid.");
          }
        }
      ],
      'end_date' => 'nullable|date|after_or_equal:start_date',
      'end_time' => [
        'nullable','string', function($attribute, $value, $fail){
          if(!strtotime($value)){
            $fail("The start time field is invalid.");
          }
        }
      ],
      'header_url' => 'nullable|string'
    ]);

    // Check for location fields. Valid if place_id is present, or name+address+city+state are present. Else return a single error.
    $validator->after(function($validator) use ($request){
      if(!$request->input('location.place_id')){
        if( !($request->input('location.name') && $request->input('location.formatted_address') && $request->input('location.city') && $request->input('location.state')) ){
          $validator->errors()->add('location', 'The event location is required.');
        }
      }
    });

    $validator->after(function($validator) use ($request){
      if($request->end_date && $request->end_time && $request->start_time && $request->start_date){
        if(strtotime($request->end_date." ".$request->end_time) <= strtotime($request->start_date." ".$request->start_time)){
          $validator->errors()->add('end_time', 'The end time must be after start time.');
        }
      }
    });

    $validator->validate();

    if($request->header_url){
      $filehelper->copyDefaultImage($request->header_url, 'default_headers', 'events');
    }

    $start_date = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : null;
    $start_time = $request->start_time ? Carbon::parse($request->start_time)->toTimeString() : null;
    $end_date =  $request->end_date ? Carbon::parse($request->end_date)->toDateString(): null;
    $end_time = $request->end_time ? Carbon::parse($request->end_time)->toTimeString() : null;

    $event = \App\Event::create([
      'name' => $request->name,
      'header_url' => $request->header_url,
      'creator_id' => Auth::user()->id,
      'group_id' => $request->group,
      'description' => $request->description,
      'start_date' => $start_date,
      'start_time' => $start_time,
      'end_date' => $end_date,
      'end_time' => $end_time,
      'location_place_id' => $request->input('location.place_id'),
      'location_name' => $request->input('location.name'),
      'location_formatted_address' => $request->input('location.formatted_address'),
      'location_city' => $request->input('location.city'),
      'location_state' => $request->input('location.state'),
      'location_map_url' => $request->input('location.map_url'),
      'location_coordinates' => $request->input('location.coordinates'),
      'flyer_processing' => true
    ]);

    // create the event flyer via queue job
    GenerateEventFlyer::dispatch($event);

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
    $filehelper = new FileHelper;

    $events = Auth::user()->getEventsForDatepicker();
    $header_images = $filehelper->getImagesInDirectory('default_headers', "Preview Header");
    JavaScript::put([
      'data' => [
        'showEndDate' => ( old('end_date',$event->end_date)?true:false ),
        'events' => (count($events) ? $events : (object) null), // AppDatepicker expects an object so we can't pass an empty php array
        'selected_location' => old('location', $event->getLocationJsonArray()),
      ]
    ]);
    return view('events.edit', ['event'=>$event,'header_images'=>$header_images]);
  }

  /*
    update() - Validate the fields submitted on the `events.edit` form. If valid, update the event model in the database.
  */
  public function update(Request $request, \App\Event $event){
    $filehelper = new FileHelper;

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'start_date' => 'required|date',
      'start_time' => [
        'nullable','string', function($attribute, $value, $fail){
          if(!strtotime($value)){
            $fail("The start time field is invalid.");
          }
        }
      ],
      'end_date' => 'nullable|date|after_or_equal:start_date',
      'end_time' => [
        'nullable','string', function($attribute, $value, $fail){
          if(!strtotime($value)){
            $fail("The start time field is invalid.");
          }
        }
      ],
      'header_url' => 'nullable|string'
    ]);

    // Check for location fields. Valid if place_id is present, or name+address+city+state are present. Else return a single error.
    $validator->after(function($validator) use ($request){
      if(!$request->input('location.place_id')){
        if( !($request->input('location.name') && $request->input('location.formatted_address') && $request->input('location.city') && $request->input('location.state')) ){
          $validator->errors()->add('location', 'The event location is required.');
        }
      }
    });

    $validator->after(function($validator) use ($request){
      if($request->end_date && $request->end_time && $request->start_time && $request->start_date){
        if(strtotime($request->end_date." ".$request->end_time) <= strtotime($request->start_date." ".$request->start_time)){
          $validator->errors()->add('end_time', 'The end time must be after start time.');
        }
      }
    });

    $validator->validate();

    if($request->header_url && $request->header_url !== $event->header_url){
      $filehelper->copyDefaultImage($request->header_url, 'default_headers', 'events');
    }

    $start_date = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : null;
    $start_time = $request->start_time ? Carbon::parse($request->start_time)->toTimeString() : null;
    $end_date =  $request->end_date ? Carbon::parse($request->end_date)->toDateString(): null;
    $end_time = $request->end_time ? Carbon::parse($request->end_time)->toTimeString() : null;
    
    $event->update([
      'name' => $request->name,
      'header_url' => $request->header_url,
      'updater_id' => Auth::user()->id,
      'description' => $request->description,
      'start_date' => $start_date,
      'start_time' => $start_time,
      'end_date' => $end_date,
      'end_time' => $end_time,
      'location_place_id' => $request->input('location.place_id'),
      'location_name' => $request->input('location.name'),
      'location_formatted_address' => $request->input('location.formatted_address'),
      'location_city' => $request->input('location.city'),
      'location_state' => $request->input('location.state'),
      'location_map_url' => $request->input('location.map_url'),
      'location_coordinates' => $request->input('location.coordinates'),
      'flyer_processing' => true
    ]);
    
    // update the event flyer via queue job
    GenerateEventFlyer::dispatch($event);

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
    $request->validate([
      'status'=>'required|in:pending,interested,going,unavailable'
    ]);

    $new_status = $request->input('status', 'pending');

    $attendee = $event->attendees()->where('user_id',Auth::user()->id)->first();
    if($attendee){
      $event->attendees()->updateExistingPivot(Auth::user()->id,[
        'status' => $new_status
      ]);
    }else{
      $event->attendees()->attach(Auth::user()->id, [
        'status' => $new_status
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
