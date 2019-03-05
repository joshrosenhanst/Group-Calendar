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
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  protected $fillable = [
    'name', 'email', 'password', 'avatar_url'
  ];

  protected $hidden = [
    'password', 'remember_token',
  ];

  /* Cast the `demo` database field (boolean integer) as a boolean true/false value */
  protected $casts = [
    'demo' => 'boolean'
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
    getJoinDateAttribute() - Accessor method that returns a formatted version of the `created_at` db field. Format 'F Y' - Ex: `February 2011`
  */
  public function getJoinDateAttribute(){
    return $this->created_at->format('F Y');
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
    $group_notifications = $this->getGroupNotifications();
    $collection = $group_notifications->concat($this->notifications)->sortByDesc('created_at');
    return $collection;
  }
  
  /*
    getAllUnreadNotificationsAttribute() - Accessor method that returns a colleciton of the user's unread notifications and unread group_unread_notifications.
  */
  public function getAllUnreadNotificationsAttribute(){
    $group_notifications = $this->getUnreadGroupNotifications();
    $collection = $group_notifications->concat($this->unreadNotifications)->sortByDesc('created_at');
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
    getUnreadGroupNotifications() - Returns a collection of all unread notifications via the user's group relation.
  */
  public function getUnreadGroupNotifications(){
    $this->loadMissing('groups.unreadNotifications');
    $collection = collect($this->groups->pluck('unreadNotifications'))->collapse()->unique();
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
    return $this->belongsToMany('App\Group')->withPivot('role');
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
}
