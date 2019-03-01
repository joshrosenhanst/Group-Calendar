<?php

Route::get('/', 'LoginController@landing')->name('landing');
Route::get('/home', 'LoginController@home')->name('home')->middleware('auth');
Route::get('/demo', 'LoginController@demo')->name('demo');
Route::get('/login', 'LoginController@login')->name('login')->middleware('guest');
Route::post('/authenticate', 'LoginController@authenticate')->name('authenticate');
Route::get('/logout', 'LoginController@logout')->name('logout');

/* Groups */
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function(){
  Route::get('/', 'GroupController@index')->name('index'); // my groups
  Route::get('/new','GroupController@new')->name('new');

  Route::get('/{group}', 'GroupController@view')->name('view'); // view group
  Route::get('/{group}/edit','GroupController@edit')->name('edit');
  Route::get('/{group}/delete','GroupController@delete')->name('delete');
  Route::get('/{group}/members','GroupController@members')->name('members');
  Route::get('/{group}/invite','GroupController@invite')->name('invite');
  Route::get('/{group}/join','GroupController@join')->name('join');

  Route::put('/create', 'GroupController@create')->name('create');
  Route::put('/sendInvite', 'GroupController@sendInvite')->name('sendInvite');
  Route::put('/acceptInvite', 'GroupController@acceptInvite')->name('acceptInvite');
  Route::put('/update', 'GroupController@update')->name('update');
  Route::delete('/delete', 'GroupController@destroy')->name('destroy');
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
  Route::get('/','ProfileController@index')->name('index'); // my profile
  Route::get('/edit','EventController@edit')->name('edit');
  
  Route::put('/update', 'EventController@update')->name('update');
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
