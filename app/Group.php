<?php
/*
  The Group model reflects a named group of users that can create events which can only be seen/interacted with by users in the group.
  Relationships:
  User: many-to-many (users can belong to many groups)
  Event: one-to-many (a group can have many events, but an event can belong to only one group)
  Comments: one-to-many polymoprhic (a group can have many comments)
*/

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Group extends Model
{
  use Notifiable;
  
  protected $fillable = [
    'name','avatar_url', 'header_url'
  ];

  /* Cast the `demo` database field (boolean integer) as a boolean true/false value */
  protected $casts = [
    'demo' => 'boolean'
  ];

  /*
    Append the following `avatar` accessor to JSON arrays.
  */
  protected $appends = [
    'avatar', 'header'
  ];

  protected $withCount = [
    'users'
  ];

  /*
    getAvatarAttribute() - Accessor method that prepends the 'groups/' directory onto the `avatar_url` db field. If it doesn't exist return the default image file.
  */
  public function getAvatarAttribute(){
    if($this->avatar_url){
      return 'storage/avatars/'.$this->avatar_url;
    }else{
      return 'img/default_user_avatar.jpg';
    }
  }

  public function getHeaderAttribute(){
    if($this->header_url){
      return 'storage/groups/'.$this->header_url;
    }else{
      return 'img/default_group_avatar.jpg';
    }
  }

  /*
    getCreateDate() - Accessor method that returns a formatted version of the `created_at` db field. Format 'F Y' - Ex: `February 2011`
  */
  public function getCreateDateAttribute(){
    return $this->created_at->format('F Y');
  }

  /*
    users() - Defines a many-to-many relationship with the User model.
  */
  public function users(){
    return $this->belongsToMany('App\User')->withPivot(['role','created_at'])->withTimestamps()->orderBy('group_user.created_at','desc');
  }

  /*
    group_invites() - Defines a many-to-many relationship with the User model using the `group_invites` table.
  */
  public function group_invites(){
    return $this->belongsToMany('App\User','group_invites')->withPivot(['creator_id','created_at'])->withTimestamps();
  }

  /*
    events() - Defines a one-to-many relationship with the Event model.
  */
  public function events(){
    return $this->hasMany('App\Event')->orderBy('start_date','asc');
  }

  /*
    upcoming_events() - Defines a one-to-many relationship with the Event model that is filtered by events after today.
  */
  public function upcoming_events(){
    return $this->hasMany('App\Event')->whereDate('start_date', '>=', Carbon::today())->orderBy('start_date','asc');
  }

  /*
    past_events() - Defines a one-to-many relationship with the Event model that is filtered by events after today.
  */
  public function past_events(){
    return $this->hasMany('App\Event')->whereDate('start_date', '<', Carbon::today())->orderBy('start_date','asc');
  }

  /*
    comments() - Defines a polymorphic relationship with the Comments model. Sort by latest (`created_at`).
  */
  public function comments(){
    return $this->morphMany('App\Comment', 'commentable')->latest();
  }

  /*
    group_notifications() - Create an alias relationship of `notifications` to allow for lazy loading constraints via the user model. 

    For example, if we want to lazy load all of the notifications of all the user's groups we can do $this->loadMissing('groups.notifications');. 

    However, if we want a 2nd collection of notifications that has a special constraint, using the same relationship name with a lazy-load constraint will override the original lazy-loaded `notifications` collection with our constrained collection.
  */
  public function group_notifications(){
    return $this->notifications();
  }

  /*
    getUpcomingEvents($limit) - Grab events that are in the future.
    $limit - number of events to grab.
  */
  public function getUpcomingEvents($limit = 4){
    $upcoming = $this->events()->upcoming()
      ->when($limit, function($query,$limit){
        return $query->limit($limit);
      })
      ->get();

    return $upcoming;
  }

  /*
    getMonthlyUpcomingEvents() - Grab events that are in the future, grouped by month. 
    Ex: [
      'January' => [$event_in_jan1, $event_in_jan2,etc],
      'February' => [$event_in_feb]
    ]
  */
  public function getMonthlyUpcomingEvents(){
    $this->loadMissing('upcoming_events.auth_user_status');
    $upcoming = $this->upcoming_events->groupBy(function($item){
      return $item->start_date->format('F Y');
    });

    return $upcoming;
  }
  /*
    getMonthlyPastEvents() - Grab events that are in the past, grouped by month + year. 
    Ex: [
      'January 2019' => [$event_in_jan1, $event_in_jan2,etc],
      'February 2019' => [$event_in_feb]
    ]
  */
  public function getMonthlyPastEvents(){
    $this->loadMissing('past_events.auth_user_status');
    $past = $this->past_events->groupBy(function($item){
      return $item->start_date->format('F Y');
    });

    return $past;
  }

  /*
    getCalendarEvents() - Grab events and format them for the vue calendar.
  */
  public function getCalendarEvents(){
    $calendar_events = [];
    foreach($this->events as $event){
      $calendar_events[] = [
        'title' => $event->name,
        'summary' => $event->start_date->format('M d').' - '.$event->name.' · '.$this->name,
        'link' => route('groups.events.view', ['event'=>$event, 'group'=>$event->group]),
        'startDate' => ($event->start_date ? $event->start_date->toDateString() : null),
        'endDate' => ($event->end_date ? $event->end_date->toDateString() : null)
      ];
    }
    return $calendar_events;
  }
}
