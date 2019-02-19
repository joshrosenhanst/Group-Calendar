<?php
/*
  The Event model reflects events created by users.
  Relationships:
  User: one-to-many (an event belongs to one creator)
  Group: one-to-many (an event belongs to one group)
  Attendees: many-to-many (users can attend many events)
  Comments: one-to-many polymoprhic (an event can have many comments)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
  protected $fillable = [
    'name', 'group_id', 'creator_id', 'header_url', 'description', 'start_date', 'start_time', 'end_date', 'end_time'
  ];

  protected $casts = [
    'start_date' => 'date:Y-m-d',
    'end_date' => 'date:Y-m-d',
  ];

  /*
    isMultiDayEvent() - Boolean check if the event is a multi day event. Check if the `end_date` is set and also check that the `start_date` doesn't match the `end_date`.
  */
  public function isMultiDayEvent(){
    return ($this->end_date && $this->start_date !== $this->end_date);
  }

  public function getHeaderAttribute(){
    if($this->header_url){
      return 'storage/events/'.$this->header_url;
    }else{
      return 'img/default_event_header.png';
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
        $summary .= " to ".Carbon::parse($this->end_time)->format('h:i A');
      }
    }
    return $summary;
  }
  
  public function getStartTimeSubtextAttribute(){
    $subtext_string = null;
    if($this->start_time){
      $subtext_string = Carbon::parse($this->start_time)->format('h:i A');
      if(!$this->end_date || $this->start_date === $this->end_date){
        if($this->end_time){
          $subtext_string .= " - " . Carbon::parse($this->end_time)->format('h:i A');
        }
      }
    }
    return $subtext_string;
  }
  
  public function getEndTimeSubtextAttribute(){
    $subtext_string = null;
    if($this->end_time){
      $subtext_string = $this->end_time->format('h:i A');
    }
    return $subtext_string;
  }

  /*
    creator() - Defines an inverse one-to-many relationship with the User model for the creator of this event.
  */
  public function creator(){
    return $this->belongsTo('App\User', 'creator_id');
  }

  /*
    attendees() - Defines a many-to-many relationship with the User model (uses the EventUser pivot).
  */
  public function attendees(){
    return $this->belongsToMany('App\User')->withPivot('status');
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
    return $this->morphMany('App\Comment', 'commentable');
  }

  /*
    scopeUpcoming() - A local scope for events that are in the future, ordered by `start_date`.
  */
  public function scopeUpcoming($query){
    return $query->whereDate('start_date', '>=', Carbon::today())->latest('start_date');
  }
}
