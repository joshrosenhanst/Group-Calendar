<?php

Route::get('/', 'LoginController@landing')->name('landing');
Route::get('/home', 'LoginController@home')->name('home')->middleware('auth');
Route::get('/demo', 'LoginController@demo')->name('demo');
Route::get('/login', 'LoginController@login')->name('login')->middleware('guest');
Route::get('/joinGroup', 'InviteController@newUserJoin')->name('joinGroup')->middleware('guest');
Route::post('/authenticate', 'LoginController@authenticate')->name('authenticate');
Route::get('/logout', 'LoginController@logout')->name('logout');

/* Groups */
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function(){
  Route::get('/', 'GroupController@index')->name('index'); // my groups
  Route::get('/new','GroupController@new')->name('new');  //non-demo auth

  Route::get('/{group}', 'GroupController@view')->name('view'); // view group
  Route::get('/{group}/edit','GroupController@edit')->name('edit'); //group admin auth
  Route::get('/{group}/members','GroupController@members')->name('members');

  Route::get('/{group}/invite','InviteController@invite')->name('invite'); //group admin auth
  Route::get('/{group}/join','InviteController@join')->name('join');
  Route::get('/{group}/decline','InviteController@decline')->name('decline');

  Route::put('/create', 'GroupController@create')->name('create');  //non-demo auth
  Route::put('/{group}/update', 'GroupController@update')->name('update'); //group admin auth

  Route::put('/{group}/createInvite', 'InviteController@createInvite')->name('createInvite'); //group admin auth
  Route::put('/{group}/acceptInvite', 'InviteController@acceptInvite')->name('acceptInvite');
  Route::put('/{group}/declineInvite', 'InviteController@declineInvite')->name('declineInvite');
});

/* Group Events */
Route::middleware('auth')->prefix('groups/{group}/events')->name('groups.events.')->group(function(){
  Route::get('/', 'GroupController@events')->name('index');
  Route::get('/new','EventController@new')->name('new');

  Route::get('/{event}','EventController@view')->name('view');
  Route::get('/{event}/edit','EventController@edit')->name('edit');
  Route::get('/{event}/delete','EventController@delete')->name('delete');
});

/* Events - Generic Events, no group required */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::get('/','EventController@index')->name('index');
  Route::get('/new','EventController@new')->name('new');
  Route::get('/{event}','EventController@event_redirect')->name('view');

  Route::put('/create', 'EventController@create')->name('create');
  Route::put('/{event}/attend','EventController@attend')->name('attend');
  Route::put('/{event}/update', 'EventController@update')->name('update');
  Route::delete('/{event}/delete', 'EventController@destroy')->name('destroy');

});

/* Users */
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
  Route::get('/{user}', 'UserController@view')->name('view');
});

/* My Profile */
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function(){
  Route::redirect('/','/home');
  Route::get('/edit','ProfileController@edit')->name('edit');
  Route::get('/password','ProfileController@password')->name('password');
  
  Route::put('/update', 'ProfileController@update')->name('update');
  Route::put('/updatePassword', 'ProfileController@updatePassword')->name('updatePassword');
});

/* Notifications */
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function(){
  Route::get('/','NotificationController@index')->name('index');
});

/* Comments */
Route::middleware('auth')->prefix('comments')->name('comments.')->group(function(){
  Route::put('/create', 'CommentController@create')->name('create');
  Route::put('/update', 'CommentController@update')->name('update');
  Route::delete('/delete', 'CommentController@destroy')->name('destroy');
});
