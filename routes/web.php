<?php

Route::get('/', 'LoginController@landing')->name('landing');
Route::get('/home', 'LoginController@home')->name('home')->middleware('auth');
Route::get('/demo', 'LoginController@demo')->name('demo');
Route::get('/login', 'LoginController@login')->name('login')->middleware('guest');
Route::post('/authenticate', 'LoginController@authenticate')->name('authenticate');
Route::get('/logout', 'LoginController@logout')->name('logout');


/* Events */
Route::middleware('auth')->prefix('events')->name('events.')->group(function(){
  Route::get('/','EventController@index')->name('index');
  Route::get('/new','EventController@new')->name('new');
  Route::get('/{event}','EventController@view')->name('view');
  Route::get('/{event}/edit','EventController@edit')->name('edit');
  Route::get('/{event}/delete','EventController@delete')->name('delete');
  Route::put('/create', 'EventController@create')->name('create');
  Route::put('/update', 'EventController@update')->name('update');
  Route::delete('/delete', 'EventController@destroy')->name('destroy');

  /* Calendar */
  Route::get('/calendar','EventController@calendar')->name('calendar');
});

/* Groups */
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function(){
  Route::get('/', 'GroupController@index')->name('index'); // my groups
  Route::get('/{group}', 'GroupController@view')->name('view'); // view group
  Route::get('/new','GroupController@new')->name('new');
  Route::get('/{group}/events','GroupController@events')->name('events');
  Route::get('/{group}/members','GroupController@members')->name('members');
  Route::get('/{group}/edit','GroupController@edit')->name('edit');
  Route::get('/{group}/delete','GroupController@delete')->name('delete');
  Route::get('/{group}/invite','GroupController@invite')->name('invite');
  Route::get('/{group}/join','GroupController@join')->name('join');
  Route::put('/create', 'GroupController@create')->name('create');
  Route::put('/sendInvite', 'GroupController@sendInvite')->name('sendInvite');
  Route::put('/acceptInvite', 'GroupController@acceptInvite')->name('acceptInvite');
  Route::put('/update', 'GroupController@update')->name('update');
  Route::delete('/delete', 'GroupController@destroy')->name('destroy');
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
