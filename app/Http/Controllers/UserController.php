<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  public function view(\App\User $user){
    $user->loadMissing('groups');
    return view('users.view', ['user'=>$user]);
  }
}
