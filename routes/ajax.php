<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
  Ajax routes are essentially web routes that do a single action used by JS - Ajax routes have sessions, CSRF protection, etc.
*/
/* NOTIFICATIONS */
Route::middleware('auth')->prefix('notifications/')->name('notifications.')->group(function(){
  Route::put('/{user}/readAll','NotificationController@readAll')->name('readAll');
});

/* EVENTS */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  /* Attendees */
  Route::put('/{event}/attend','EventController@attend')->name('attend');

  /* Comments */
  Route::put('/{event}/comment/create','EventController@createComment')->name('createComment');
  Route::put('/{event}/comment/{comment}/update','EventController@updateComment')->name('updateComment');
  Route::delete('/{event}/comment/{comment}/delete','EventController@destroyComment')->name('destroyComment');
});

/* GROUPS */
Route::middleware('auth')->prefix('groups/')->name('groups.')->group(function(){
  /* Members */
  Route::put('/{group}/member/update','GroupController@updateMember')->name('updateMember');
  Route::delete('/{group}/member/remove','GroupController@removeMember')->name('deleteMember');

  /* Comments */
  Route::put('/{group}/comment/create','GroupController@createComment')->name('createComment');
  Route::put('/{group}/comment/{comment}/update','GroupController@updateComment')->name('updateComment');
  Route::delete('/{group}/comment/{comment}/delete','GroupController@destroyComment')->name('destroyComment');
});