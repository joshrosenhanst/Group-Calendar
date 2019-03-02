<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
  /*
    edit() - Display the `profile.edit` template.
  */
  public function edit(){
    return view('profile.edit');
  }

  /*
    password() - Display the `profile.password` template.
  */
  public function password(){
    return view('profile.password');
  }

  /*
    update() - Validate the fields on `profile.edit` template. If valid, update the user record on the database.
  */
  public function update(Request $request){
    /*$request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email_address',
    ]);*/
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:255|string',
      'email' => [
        'required','email','max:255',Rule::unique('users')->ignore(Auth::user()->id)
      ]
    ])->validate();
    /*if($validator->fails()){
      return redirect()->route('profile.edit')->withErrors($validator)->withInput();
    }*/

    Auth::user()->update([
      'name' => $request->name,
      'email' => $request->email,
      //avatar url
    ]);

    return redirect()->route('profile.index')->with('status', 'Your profile has been updated.');
  }

  public function updatePassword(Request $request){
    $validator = Validator::make($request->all(), [
      'current_password' => 'required|string',
      'new_password' => 'required|string|min:6|different:current_password|confirmed'
    ]);

    $validator->after(function($validator) use ($request){
      if( !Hash::check($request->current_password, Auth::user()->password) ){
        $validator->errors->add('current_password', 'Incorrect password.');
      }
    });

    Auth::user()->update([
      'password' => Hash::make($request->new_password)
    ]);

    return redirect()->route('profile.index')->with('status', 'Your password has been updated.');
  }
}
