<?php
/*
  The Comment model reflects text comments that can be made on both an Event and a Group.
  The different types of comments are stored on the same database table, and accessed through a polymorphic relationship.
  Relationships:
  Event/Group - Polymorphic one-to-many (an event can have many comments; a group can have many comments.)
  User - many-to-one (a user may have many comments, but a comment can only have 1 creator)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
    'text', 'user_id'
  ];

  protected $appends = [
    'created_text', 'updated_text', 'edited'
  ];

  /*
    getEditedAttribute() - Accessor method that determines if the comment has ever been edited. Returns a boolean.
  */
  public function getEditedAttribute(){
    return ($this->created_at !== $this->updated_at);
  }

  /*
    getCreatedTextAttribute() - Accessor method that converts the `created_at` timestamp into a human readable format like '22 hours ago'
  */
  public function getCreatedTextAttribute(){
    return $this->created_at->diffForHumans();
  }

  /*
    getCreatedTextAttribute() - Accessor method that converts the `updated_at` timestamp into a human readable format like '22 hours ago'
  */
  public function getUpdatedTextAttribute(){
    return $this->updated_at->diffForHumans();
  }
  
  public function commentable(){
    return $this->morphTo();
  }

  public function user(){
    return $this->belongsTo('App\User');
  }
}
