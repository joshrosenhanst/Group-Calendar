<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
  Ajax routes are essentially web routes that do a single action used by JS - Ajax routes have sessions, CSRF protection, etc.
*/
/* NOTIFICATIONS */
Route::middleware('auth')->prefix('notifications/')->name('notifications.')->group(function(){
  Route::put('/{user}/readAll', [NotificationController::class, 'readAll'])->name('readAll');
});

/* EVENTS */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::get('/{event}', [EventController::class, 'getEvent'])->middleware('can:view,event')->name('getEvent');

  /* Attendees */
  Route::put('/{event}/attend', [EventController::class, 'attend'])->middleware('can:attend,event')->name('attend');

  /* 
    Comments:
    Comment routes use policy middleware to check the Auth::user's privileges.
  */
  Route::put('/{event}/comment/create', [EventController::class, 'createComment'])->middleware('can:createComment,event')->name('createComment');
  Route::put('/{event}/comment/{comment}/update', [EventController::class, 'updateComment'])->middleware('can:updateComment,event,comment')->name('updateComment');
  Route::delete('/{event}/comment/{comment}/delete', [EventController::class, 'destroyComment'])->middleware('can:destroyComment,event,comment')->name('destroyComment');
});

/* GROUPS */
Route::middleware('auth')->prefix('groups/')->name('groups.')->group(function(){
  /* 
    Members:
    Member routes use policy middleware to check the Auth::user's privileges.
  */
  Route::put('/{group}/member/update', [GroupController::class, 'updateMember'])->middleware('can:updateMember,group')->name('updateMember');
  Route::delete('/{group}/member/remove', [GroupController::class, 'removeMember'])->middleware('can:deleteMember,group')->name('deleteMember');

  
  /* 
    Comments:
    Comment routes use policy middleware to check the Auth::user's privileges.
  */
  Route::put('/{group}/comment/create', [GroupController::class, 'createComment'])->middleware('can:createComment,group')->name('createComment');
  Route::put('/{group}/comment/{comment}/update', [GroupController::class, 'updateComment'])->middleware('can:updateComment,group,comment')->name('updateComment');
  Route::delete('/{group}/comment/{comment}/delete', [GroupController::class, 'destroyComment'])->middleware('can:destroyComment,group,comment')->name('destroyComment');
});