<?php
/*
  The EventUser model is the pivot table for the many-to-many relationship between the Event and User models.
*/
namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    //
}
