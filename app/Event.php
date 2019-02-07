<?php
/*
  The Event model reflects events created by users.
  Relationships:
  User: one-to-many (an event belongs to one creator)
  Group: one-to-many (an event belongs to one group)
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

  public function getHeaderAttribute(){
    if($this->header_url){
      return 'events/'.$this->header_url;
    }else{
      return 'default_event_header.png';
    }
  }

  public function getSummaryDateAttribute(){
    if($this->end_date){
      return $this->start_date . " - ". $this->end_date;
    }else{
      return $this->start_date . " " . $this->start_time;
    }
  }

  /*
    creator() - Defines an inverse one-to-many relationship with the User model for the creator of this event.
  */
  public function creator(){
    return $this->belongsTo('App\User', 'creator_id');
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
