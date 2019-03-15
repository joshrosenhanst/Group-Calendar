<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

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
    Check if the user account exists and is not a demo account.
    Attempt the login credentials, if successful redirect to the intended route (fallback to /home). If the login fails, redirect to the login page with a login failed error and the old input.
  */
  public function authenticate(Request $request){
    $credentials = $request->only('email', 'password');
    $remember = $request->only('remember');

    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);

    $validator->after(function($validator) use ($request){
      $user_account = \App\User::where('email',$request->email)->first();
      if($user_account && $user_account->demo){
        $validator->errors()->add('email', 'Unable to log into demo account. Use the Try a Demo link instead.');
      }
    });

    $validator->validate();

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
    home() - Redirect the user to the `groups.view` route if they have 1 group, or the `groups.list` otherwise.
  */
  public function home(){
    return view('home');
  }

  /*
    home() - Display the `landing` page template.
  */
  public function landing(){
    return view('landing');
  }

  /*
    demo() - Put a logged out user into demo mode by grabbing a random demo account and logging them in.
  */
  public function demo(){
    //enable demo mode
    $user = \App\User::where("demo","1")->inRandomOrder()->first();

    // log them in as the random user
    Auth::login($user);

    return redirect()->route('home')->with('status','You have been logged in to a random demo account.');
  }

  /*
    logout() - Log the user out and then redirect to the landing page.
  */
  public function logout(){
    Auth::logout();
    return redirect('/');
  }
}
