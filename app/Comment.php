<?php
/*
  The Comment model reflects text comments that can be made on both an Event and a Group.
  The different types of comments are stored on the same database table, and accessed through a polymorphic relationship.
  Relationships:
  Event/Group - Polymorphic one-to-many (an event can have many comments; a group can have many comments.)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  public function commentable(){
    return $this->morphTo();
  }
}
