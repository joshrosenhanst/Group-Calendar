<?php
/*
  The GroupUser model is the pivot table for the many-to-many relationship between the Group and User models.
*/

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupUser extends Pivot
{
    //
}
