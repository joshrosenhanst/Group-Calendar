<?php
/*
  The GroupInvites model is the pivot table for the many-to-many relationship between the Group and User models using the `group_invites` table.
*/

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupInvites extends Pivot
{
  /*
    creator() - Defines an inverse one-to-many relationship with the User model for the user that created this invite.
  */
  public function inviter(){
    return $this->belongsTo('App\User', 'creator_id');
  }
}
