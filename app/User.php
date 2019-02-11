<?php
/*
  The User model reflects users of the application.
  Relationships:
  Group: many-to-many (users can belong to many different groups)
  Event: one-to-many (a user can create many events, but an event can only have 1 creator)
  Comment: one-to-many (a user can create many comments, but a comment can only have 1 creator)
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
    Append the following `avatar` accessor to JSON arrays.
  */
  protected $appends = [
    'avatar'
  ];

  /*
    getAvatarAttribute() - Accessor method that prepends the 'avatars/' directory onto the `avatar_url` db field. If it doesn't exist return the default image file.
  */
  public function getAvatarAttribute(){
    if($this->avatar_url){
      return 'avatars/'.$this->avatar_url;
    }else{
      return 'img/default_user_avatar.png';
    }
  }

  /*
    groups() - Defines a many-to-many relationship with the Group model.
  */
  public function groups(){
    return $this->belongsToMany('App\Group');
  }

  /*
    events() - Defines a one-to-many relationship with the Event model.
  */
  public function events(){
    return $this->hasMany('App\Event','creator_id');
  }

  /*
    comments() - Defines a one-to-many relationship with the Comment model.
  */
  public function comments(){
    return $this->hasMany('App\Comment');
  }
}
