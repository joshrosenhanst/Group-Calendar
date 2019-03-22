<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function index(Request $request){
    Auth::user()->markNotificationsAsRead();
    $page = $request->page ?? 0;
    $notifications = Auth::user()->all_notifications->paginate(25, $page);
    return view('notifications.index', ['notifications'=>$notifications]);
  }
}
