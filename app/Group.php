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

  /*
    getAvatarAttribute() - Accessor method that prepends the 'groups/' directory onto the `avatar_url` db field. If it doesn't exist return the default image file.
  */
  public function getAvatarAttribute(){
    if($this->avatar_url){
      return 'groups/'.$this->avatar_url;
    }else{
      return 'default_group_avatar.png';
    }
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
    return $this->hasMany('App\Event');
  }

  /*
    comments() - Defines a polymorphic relationship with the Comments model.
  */
  public function comments(){
    return $this->morphMany('App\Comment', 'commentable');
  }

  /*
    latest_comments() - Combine the group's comments and the comments on the group's events into one collection and then return the first 5.
  */
  public function latest_comments(){
    $this->loadMissing(['events.comments','comments']);

    $collection = $this->events()->comments()->concat($this->comments());
    $sorted = $collection->sortByDesc('created_at');

    return $sorted->take(5)->all();
  }
}
