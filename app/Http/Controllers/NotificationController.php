<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function index(){
    /*Auth::user()->all_unread_notifications->each(function($notification){
      $notification->markAsRead();
    });*/
    Auth::user()->markNotificationsAsRead();
    return view('notifications.index');
  }
}
