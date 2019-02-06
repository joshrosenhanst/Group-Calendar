<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller{
  use ThrottlesLogins;

  /*
    username() - Defines this->username() value to 'email' for the ThrottlesLogins trait
  */
  public function username(){
    return 'email';
  }

  public function authenticate(Request $request){
    $credentials = $request->only('email', 'password');
    $remember = $request->only('remember');

    $validate = $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);

    if($this->hasTooManyLoginAttempts($request)) {
      $this->fireLockoutEvent($request);
      return $this->sendLockoutResponse($request);
    }

    if(Auth::attempt($credentials, $remember)){
      return redirect()->intended('home');
    }else{
      $this->incrementLoginAttempts($request);
      return redirect('login')->withErrors([
        'email' => __('auth.failed')
      ]);
    }
  }

  public function login(){
    return view('login');
  }

  public function home()
  {
    return view('home');
  }

  public function landing(){
    return view('landing');
  }

  public function demo(){
    //enable demo mode
  }

  public function logout(Request $request){
    Auth::logout();
    return redirect('/');
  }
}
