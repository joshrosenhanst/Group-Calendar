<?php
/*
  The Group model reflects a named group of users that can create events which can only be seen/interacted with by users in the group.
  Relationships:
  User: many-to-many (users can belong to many groups)
  Event: one-to-many (a group can have many events, but an event can belong to only one group)
  Comments: one-to-many polymoprhic (a group can have many comments)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = [
    'name','avatar_url'
  ];

  /* Cast the `demo` database field (boolean integer) as a boolean true/false value */
  protected $casts = [
    'demo' => 'boolean'
  ];

  /*
    Append the following `avatar` accessor to JSON arrays.
  */
  protected $appends = [
    'avatar'
  ];

  protected $withCount = [
    'users'
  ];

  /*
    getAvatarAttribute() - Accessor method that prepends the 'groups/' directory onto the `avatar_url` db field. If it doesn't exist return the default image file.
  */
  public function getAvatarAttribute(){
    if($this->avatar_url){
      return 'storage/groups/'.$this->avatar_url;
    }else{
      return 'img/default_group_avatar.png';
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
    return $this->belongsToMany('App\User');
  }

  /*
    events() - Defines a one to many relationship with the Event model.
  */
  public function events(){
    return $this->hasMany('App\Event')->latest();
  }

  /*
    comments() - Defines a polymorphic relationship with the Comments model. Sort by latest (`created_at`).
  */
  public function comments(){
    return $this->morphMany('App\Comment', 'commentable')->latest();
  }

  /*
    getUpcomingEvents($limit) - Grab events that are in the future.
    $limit - number of events to grab.
  */
  public function getUpcomingEvents($limit = 4){
    return $this->events()->upcoming()->limit($limit)->get();
  }
}
