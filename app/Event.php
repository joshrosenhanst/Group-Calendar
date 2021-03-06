<?php
/*
  The Event model reflects events created by users.
  Relationships:
  Creator User: one-to-many (an event belongs to one creator)
  Updater User: one-to-many (an event belongs to one updater)
  Group: one-to-many (an event belongs to one group)
  Attendees: many-to-many (users can attend many events)
  Comments: one-to-many polymoprhic (an event can have many comments)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
  protected $fillable = [
    'name', 'group_id', 'creator_id', 'updater_id', 'header_url', 'description', 'start_date', 'start_time', 'end_date', 'end_time', 'location_place_id', 'location_name', 'location_formatted_address', 'location_city', 'location_state', 'location_map_url', 'location_coordinates', 'flyer_url', 'flyer_processing'
  ];

  protected $casts = [
    'start_date' => 'date:Y-m-d',
    'end_date' => 'date:Y-m-d',
    'flyer_processing' => 'boolean'
  ];

  protected $appends = ['user_status','summary_date','start_time_subtext'];

  protected $hidden = ['auth_user_status'];

  /*
    Eager load the count of `going_attendees` and `interested_attendees` relationships whenever an event is queried.
  */
  protected $withCount = [
    'going_attendees', 'interested_attendees'
  ];

  /*
    getEditedAttribute() - Accessor method that determines if the event has been edited. Returns a boolean.
  */
  public function getEditedAttribute(){
    return ($this->created_at != $this->updated_at);
  }

  /*
    isMultiDayEvent() - Boolean check if the event is a multi day event. Check if the `end_date` is set and also check that the `start_date` doesn't match the `end_date`.
  */
  public function isMultiDayEvent(){
    return ($this->end_date && $this->start_date->toDateString() !== $this->end_date->toDateString());
  }

  /*
    getHeaderAttribute() - Accessor method to retun the full url of the event's header or a default image.
  */
  public function getHeaderAttribute(){
    if($this->header_url){
      return 'storage/events/'.$this->header_url;
    }else{
      return 'img/default_event_header.jpg';
    }
  }

  /*
    getFlyerAttribute() - Accessor method to retun the full url of the event's flyer, if it is set.
  */
  public function getFlyerAttribute(){
    if($this->flyer_url){
      return 'storage/flyers/'.$this->flyer_url;
    }else{
      return null;
    }
  }

  /*
    getSummaryDateAttribute() - Accessor method to print out a clean, human readable date and time range for the event. Returns different strings based on available date/time fields.
    Start Date only: Ex: 'Fri, Feb 21'
    Start Date and Start Time only: Ex: 'Fri, Feb 21 at 12:30 PM'
    Start Date and End Date only (multi date): Ex: 'Fri, Feb 21 to Sun, Feb 23'
    Start Date, End Date, Start Time, End Time: Ex: 'Fri, Feb 21 at 12:30 PM to Sun, Feb 23 at 1:00 PM'
  */
  public function getSummaryDateAttribute(){
    $summary = $this->start_date->format('D, M j');
    if($this->start_time){
      $summary .= " at ".Carbon::parse($this->start_time)->format('h:i A');
    }
    if($this->isMultiDayEvent()){
      $summary .= " to ".$this->end_date->format('D, M j');
      if($this->end_time){
        $summary .= " at ".Carbon::parse($this->end_time)->format('h:i A');
      }
    }else{
      if($this->end_time){
        $summary .= " - ".Carbon::parse($this->end_time)->format('h:i A');
      }
    }
    return $summary;
  }
  
  public function getStartTimeSubtextAttribute(){
    $subtext_string = null;
    if($this->start_time){
      $subtext_string = $this->start_date->format('D')." ".Carbon::parse($this->start_time)->format('g:i A');

      if($this->end_time){
        $subtext_string .= " - ";
        if($this->end_date && $this->start_date->toDateString() !== $this->end_date->toDateString()){
          $subtext_string .= $this->end_date->format('D')." ";
        }
        $subtext_string .= Carbon::parse($this->end_time)->format('h:i A');
      }
    }
    return $subtext_string;
  }

  /*
    getUserStatusAttribute() - Accessor method to print out the current Auth::user() attendee status on this event. If the status is not set or the user doesn't exist we fall back to the default value `pending`.
  */
  public function getUserStatusAttribute(){
    $user_status = $this->auth_user_status ? $this->auth_user_status->first() : null;
    if($user_status){ 
      return $user_status->status ?? 'pending';
    }else{
      return 'pending';
    }
  }

  /*
    getCityStateAttribute - Accessor method to print out the event's location city + state.
  */
  public function getCityStateAttribute(){
    return $this->getLocationCityState();
  }

  /*
    creator() - Defines an inverse one-to-many relationship with the User model for the creator of this event.
  */
  public function creator(){
    return $this->belongsTo('App\User', 'creator_id');
  }

  /*
    action_last_user() - Defines an inverse one-to-many relationship with the User model for the user that last updated the event.
  */
  public function updater(){
    return $this->belongsTo('App\User', 'updater_id');
  }

  /*
    attendees() - Defines a many-to-many relationship with the User model (using the EventUser pivot).
  */
  public function attendees(){
    return $this->belongsToMany('App\User')->withPivot('status')->orderBy('pivot_status','desc')->orderBy('name', 'asc');
  }

  /*
    auth_user_status() - Access the attendee status for the Auth::user() by creating a filtered relationship. 
    Status field can be accessed via auth_user_status->first()->status or through the accessor `user_status` using `getUserStatusAttribute()`
    If there is no authorized user (i.e API/tests), should return an empty array.
  */
  public function auth_user_status(){
    $user_id = Auth::user() ? Auth::user()->id : null;

    return $this->belongsToMany('App\User')->withPivot('status')->wherePivot('user_id',$user_id)->select('status');
  }

  /*
    going_attendees() - Defines a many-to-many relationship with the User model (using the EventUser pivot), filtered by `status=going`.
  */
  public function going_attendees(){
    return $this->belongstoMany('App\User')->wherePivot('status', 'going');
  }

  /*
    interested_attendees() - Defines a many-to-many relationship with the User model (using the EventUser pivot), filtered by `status=interested`.
  */
  public function interested_attendees(){
    return $this->belongstoMany('App\User')->wherePivot('status', 'interested');
  }

  /*
    group() - Defines an inverse one-to-many relationship with the Group model for the group this event belongs to.
  */
  public function group(){
    return $this->belongsTo('App\Group');
  }

  /*
    comments() - Defines a polymorphic relationship with the Comments model.
  */
  public function comments(){
    return $this->morphMany('App\Comment', 'commentable')->latest();
  }

  /*
    scopeUpcoming() - A local scope for events that are in the future.
  */
  public function scopeUpcoming($query){
    return $query->whereDate('start_date', '>=', Carbon::today());
  }
  
  /*
    scopePast() - A local scope for events that are in the past.
  */
  public function scopePast($query){
    return $query->whereDate('start_date', '<', Carbon::today());
  }

  /*
    getLocationJsonArray() - Return the getLocationArray() or a null object for JSON.
  */
  public function getLocationJsonArray(){
    if($this->location_place_id){
      return $this->getLocationArray();
    }else{
      return (object) null;
    }
  }

  /*
    getLocationArray() - Return an array of location fields if they are set.
  */
  public function getLocationArray(){
    return [
      'place_id' => $this->location_place_id,
      'name' => $this->location_name,
      'formatted_address' => $this->location_formatted_address,
      'city' => $this->location_city,
      'state' => $this->location_state,
      'map_url' => $this->location_map_url,
      'coordinates' => $this->location_coordinates
    ];
  }

  public function getLocationCityState(){
    if($this->location_city && $this->location_state){
      return $this->location_city.", ".$this->location_state;
    }else{
      if($this->location_city) return $this->location_city;
      if($this->location_state) return $this->location_state;

      return null;
    }
  }
}
