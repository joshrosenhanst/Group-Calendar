<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
  /*
    Append the following accessors to JSON arrays.
  */
  protected $appends = [
    'created_text'
  ];

  /*
    getCreatedTextAttribute() - Accessor method that returns a formatted version of the `created_at` db field. Formatted as '22 hours ago'.
  */
  public function getCreatedTextAttribute(){
    return $this->created_at->diffForHumans();
  }
}