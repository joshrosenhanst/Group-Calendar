<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
  Ajax routes are essentially web routes that do a single action used by JS - Ajax routes have sessions, CSRF protection, etc.
*/
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::put('/{event}/attend','EventController@attend')->name('attend');
  Route::put('/{event}/comment/create','EventController@createComment')->name('createComment');
  Route::put('/{event}/comment/{comment}/update','EventController@updateComment')->name('updateComment');
  Route::delete('/{event}/comment/{comment}/delete','EventController@destroyComment')->name('destroyComment');
});