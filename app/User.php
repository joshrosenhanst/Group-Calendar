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

  public function getEventsAttribute(){
    return $this->getEvents();
  }

  public function getUpcomingEventsAttribute(){
    return $this->getUpcomingEvents();
  }

  /*
    getEvents() - Returns a collection of all available events via the user's group relation. Used by the `getEventsAttribute()` accessor.
  */
  public function getEvents(){
    $this->load('groups.events');
    $collection = collect($this->groups->pluck('events'))->collapse()->unique();
    return $collection;
  }

  /*
    getUpcomingEvents() - Returns a collection of all available events via the user's group relation. Used by the `getEventsAttribute()` accessor.
  */
  public function getUpcomingEvents(){
    $this->load('groups.upcoming_events');
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
