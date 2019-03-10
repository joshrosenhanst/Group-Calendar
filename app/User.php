<?php
/*
  The User model reflects users of the application.
  Relationships:
  Group: many-to-many (users can belong to many different groups)
  Comment: one-to-many (a user can create many comments, but a comment can only have 1 creator)
  Created Events: one-to-many (a user can create many events, but an event can only have 1 creator)
  Attending Events: many-to-many (users can attend many events)
*/

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
  use Notifiable;

  protected $fillable = [
    'name', 'email', 'password', 'avatar_url', 'notifications_last_read_at', 'account_setup'
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  /* Cast the `demo` database field (boolean integer) as a boolean true/false value */
  protected $casts = [
    'demo' => 'boolean',
    'account_setup' => 'boolean',
    'notifications_last_read_at' => 'datetime'
  ];

  /*
    Append the following accessors to JSON arrays.
  */
  protected $appends = [
    'avatar', 'join_date'
  ];

  /*
    getAvatarAttribute() - Accessor method that prepends the 'storage/avatars/' directory onto the `avatar_url` db field. If it doesn't exist return the default image file.
  */
  public function getAvatarAttribute(){
    if($this->avatar_url){
      return 'storage/avatars/'.$this->avatar_url;
    }else{
      return 'img/default_user_avatar.png';
    }
  }
  
  /*
    getGroupSelectAttribute() - Acessor method that returns an array of names and ids of the user's groups, which can be rendered into a <select> html tag.
  */
  public function getGroupSelectAttribute(){
    return $this->groups->map(function ($group){
      return [
        'text' => $group->name,
        'value' => $group->id
      ];
    });
  }

  /*
    markNotificationsAsRead() - Update the `notifications_last_read_at` timestamp to now.
  */
  public function markNotificationsAsRead(){
    $this->update([
      'notifications_last_read_at' => Carbon::now()
    ]);
  }

  /*
    getJoinDateAttribute() - Accessor method that returns a formatted version of the `pivot->created_at` db field. Formatted as '22 hours ago'. Because pivot is generic, this can apply to both the `GroupUser` and `GroupInvites` pivots.
  */
  public function getJoinDateAttribute(){
    if($this->pivot && $this->pivot->created_at){
      return $this->pivot->created_at->diffForHumans();
    }else{
      return null;
    }
  }

  /*
    getEventsAttribute() - Accessor method that returns all events in the user's groups.
  */
  public function getEventsAttribute(){
    return $this->getEvents();
  }

  /*
    getEventsAttribute() - Accessor method that returns upcoming events in the user's groups.
  */
  public function getUpcomingEventsAttribute(){
    return $this->getUpcomingEvents();
  }

  /*
    getAllNotificationsAttribute() - Accessor method that returns a collection of the user's notifications and group_notifications.
  */
  public function getAllNotificationsAttribute(){
    //$this->loadMissing('notifications');
    $group_notifications = $this->getGroupNotifications();

    $collection = $group_notifications->concat($this->notifications)->sortByDesc('created_at');
    return $collection;
  }
  
  /*
    getAllUnreadNotificationsAttribute() - Accessor method that returns a colleciton of the user's unread notifications and unread group_notifications.
  */
  public function getAllUnreadNotificationsAttribute(){
    //$this->loadMissing('unread_notifications');
    $group_notifications = $this->getUnreadGroupNotifications();

    $collection = $group_notifications->concat($this->unread_notifications)->sortByDesc('created_at');
    return $collection;
  }

  /*
    getGroupNotificationsAttribute() - Accessor method that returns notifications in the user's groups.
  */
  public function getGroupNotificationsAttribute(){
    return $this->getGroupNotifications();
  }
  
  /*
    getGroupNotifications() - Returns a collection of all notifications via the user's group relation. Used by the `getGroupNotificationsAttribute()` accessor.
  */
  public function getGroupNotifications(){
    $this->loadMissing('groups.notifications');

    $collection = collect($this->groups->pluck('notifications'))->collapse()->unique();
    return $collection;
  }

  /*
    getUnreadGroupNotifications() - Returns a collection of all unread notifications (based on the user's `notifications_last_read_at` value) via the user's group relation.
  */
  public function getUnreadGroupNotifications(){
    if(is_null($this->notifications_last_read_at)){
      $this->loadMissing('groups.group_notifications');
    }else{
      $this->loadMissing(['groups','groups.group_notifications' => function($query){
        $query->where('created_at','>',$this->notifications_last_read_at);
      }]);
    }

    $collection = collect($this->groups->pluck('group_notifications'))->collapse()->unique();
    return $collection;
  }

  /*
    getEventsForDatepicker() - Returns a collection of all available events via the user's group relation. Each group gets a random color and that color is added to each event from the group. Return a collection keyed by start_date->toDateTimeString().
    Ex: ["2019-03-14 00:00:00] => [event1,event2],
        ["2019-05-15 00:00:00] => [event3, event4]
    Each event has a summary and a color value.
  */
  public function getEventsForDatepicker(){
    $this->loadMissing('groups.events');
    $events = [];
    $colors = [];
    foreach($this->groups as $group){
      $colors[$group->id] = sprintf('#%06X', mt_rand(0, 0xCCCCCC));
      $group_events = $group->events->makeHidden('user_status')->toArray();
      foreach($group_events as $event){
        $start_date = Carbon::parse($event['start_date'])->toDateTimeString();
        $events[$start_date][] = [
          'summary' => $event['name'].": ".$event['summary_date'],
          'color' => $colors[$event['group_id']]
        ];
      }
    }
    //$collection = collect($this->groups->pluck('events','id'))->collapse()->unique();
    $collection = collect($events)->unique();
    return $collection;
  }

  /*
    getEvents() - Returns a collection of all available events via the user's group relation. Used by the `getEventsAttribute()` accessor.
  */
  public function getEvents(){
    $this->loadMissing('groups.events');
    $collection = collect($this->groups->pluck('events'))->collapse()->unique();
    return $collection;
  }

  /*
    getUpcomingEvents() - Returns a collection of all available events via the user's group relation. Used by the `getEventsAttribute()` accessor.
  */
  public function getUpcomingEvents(){
    $this->loadMissing('groups.upcoming_events');
    $collection = collect($this->groups->pluck('upcoming_events'))->collapse()->unique();
    return $collection;
  }

  /*
    groups() - Defines a many-to-many relationship with the Group model.
  */
  public function groups(){
    return $this->belongsToMany('App\Group')->withPivot(['role','created_at'])->withTimestamps();
  }

  /*
    created_events() - Defines a one-to-many relationship with the Event model.
  */
  public function created_events(){
    return $this->hasMany('App\Event','creator_id');
  }

  /*
    attending() - Defines a many-to-many relationship with the Event model (uses the EventUser pivot).
  */
  public function attending_events(){
    return $this->belongsToMany('App\Event')->withPivot('status');
  }

  /*
    comments() - Defines a one-to-many relationship with the Comment model.
  */
  public function comments(){
    return $this->hasMany('App\Comment');
  }

  /*
    unread_notifications() - Return a notifications() relationship filtered by notifcations created after the user's `notifications_last_read_at' timestamp.
  */
  public function unread_notifications(){
    if(is_null($this->notifications_last_read_at)){
      return $this->notifications();
    }else{
      return $this->notifications()->where('created_at','>',$this->notifications_last_read_at);
    }
  }
}
