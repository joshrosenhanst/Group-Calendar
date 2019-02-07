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

  /*
    authenticate() - Login form submission via POST request.
    Validate the login input fields and check the ThrottlesLogin trait login attempts.
    Attempt the login credentials, if successful redirect to the intended route (fallback to /home). If the login fails, redirect to the login page with a login failed error and the old input.
  */
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
      return redirect()->route('login')->withErrors([
        'email' => __('auth.failed')
      ])->withInput();
    }
  }

  /*
    login() - Display the `login` page template.
  */
  public function login(){
    return view('login');
  }

  /*
    home() - Display the `home` page template.
  */
  public function home(){
    $groups = Auth::user()->groups()->with(['events.comments'])->get();
    if($groups->count() !== 1){
      $groups->load('comments');
    }
    return view('home', ['groups'=>$groups]);
  }

  /*
    home() - Display the `landing` page template.
  */
  public function landing(){
    return view('landing');
  }

  public function demo(){
    //enable demo mode
  }

  /*
    logout() - Log the user out and then redirect to the landing page.
  */
  public function logout(){
    Auth::logout();
    return redirect('/');
  }
}
