<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
  public function readAll(\App\User $user){
    $user->all_unread_notifications->each(function($notification){
      $notification->markAsRead();
    });

    return response()->json($user->all_notifications);
  }
}
