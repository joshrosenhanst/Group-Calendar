<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Facades\FileHelper;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
  /*
    edit() - Display the `profile.edit` template.
  */
  public function edit(){
    $avatar_images = FileHelper::getImagesInDirectory('default_avatars', "Preview Avatar");
    return view('profile.edit', ['avatar_images'=>$avatar_images]);
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
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:255|string',
      'email' => [
        'required','email','max:255',Rule::unique('users')->ignore(Auth::user()->id)
      ],
      'avatar_url' => 'nullable|string'
    ])->validate();

    if($request->avatar_url && $request->avatar_url !== Auth::user()->avatar_url){
      FileHelper::copyDefaultImage($request->avatar_url, 'default_avatars', 'avatars');
    }

    Auth::user()->update([
      'name' => $request->name,
      'email' => $request->email,
      'avatar_url' => $request->avatar_url
    ]);

    return redirect()->route('home')->with('status', 'Your profile has been updated.');
  }

  public function updatePassword(Request $request){
    $validator = Validator::make($request->all(), [
      'current_password' => 'required|string',
      'new_password' => 'required|string|min:6|different:current_password|confirmed',
      'new_password_confirmation' => 'required|string'
    ]);

    $validator->after(function($validator) use ($request){
      if( !Hash::check($request->current_password, Auth::user()->password) ){
        $validator->errors()->add('current_password', 'Incorrect password.');
      }
    });

    $validator->validate();

    Auth::user()->update([
      'password' => Hash::make($request->new_password)
    ]);

    return redirect()->route('home')->with('status', 'Your password has been updated.');
  }
}
