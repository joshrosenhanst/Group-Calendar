<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function readAll(\App\User $user){
    $user->markNotificationsAsRead();

    return response()->json($user->all_unread_notifications->count());
  }
}
