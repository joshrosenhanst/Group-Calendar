<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
  Ajax routes are essentially web routes that do a single action used by JS - Ajax routes have sessions, CSRF protection, etc.
*/
/* EVENTS */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::put('/{event}/attend','EventController@attend')->name('attend');
  Route::put('/{event}/comment/create','EventController@createComment')->name('createComment');
  Route::put('/{event}/comment/{comment}/update','EventController@updateComment')->name('updateComment');
  Route::delete('/{event}/comment/{comment}/delete','EventController@destroyComment')->name('destroyComment');
});

/* GROUPS */
Route::middleware('auth')->prefix('groups/')->name('groups.')->group(function(){
  Route::put('/{group}/member/update','GroupController@updateMember')->name('updateMember');
  Route::put('/{group}/member/delete','GroupController@deleteMember')->name('deleteMember');
  /* Group Comments */
  Route::put('/{group}/comment/create','GroupController@createComment')->name('createComment');
  Route::put('/{group}/comment/{comment}/update','GroupController@updateComment')->name('updateComment');
  Route::delete('/{group}/comment/{comment}/delete','GroupController@destroyComment')->name('destroyComment');
});