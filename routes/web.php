<?php

Route::get('/', 'LoginController@landing')->name('landing');
Route::get('/home', 'LoginController@home')->name('home')->middleware('auth');
Route::get('/demo', 'LoginController@demo')->name('demo')->middleware('guest');
Route::get('/login', 'LoginController@login')->name('login')->middleware('guest');
Route::post('/authenticate', 'LoginController@authenticate')->name('authenticate');
Route::get('/logout', 'LoginController@logout')->name('logout');

/* New User Invitations */
Route::get('/register', 'InviteController@register')->name('register')->middleware('guest');
Route::put('/submitRegistration', 'InviteController@submitRegistration')->name('submitRegistration')->middleware('guest');

/* Group Invitations List */
Route::get('/invitations', 'InviteController@index')->name('invitations')->middleware('auth');

/* 
  Groups:
  Group routes use policy middleware to check the Auth::user's privileges.
  Routes that don't require auth: index, join, decline, acceptInvite, declineInvite
*/
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function(){
  Route::get('/', 'GroupController@index')->name('index'); // my groups
  Route::get('/new','GroupController@new')->middleware('can:new,App\Group')->name('new');

  Route::get('/{group}', 'GroupController@view')->middleware('can:view,group')->name('view');
  Route::get('/{group}/members','GroupController@members')->middleware('can:members,group')->name('members');
  Route::get('/{group}/leave','GroupController@leave')->middleware('can:leave,group')->name('leave');
  Route::get('/{group}/edit','GroupController@edit')->middleware('can:edit,group')->name('edit');

  Route::get('/{group}/join','InviteController@join')->name('invites.join');
  Route::get('/{group}/decline','InviteController@decline')->name('invites.decline');
  Route::get('/{group}/invite','InviteController@invite')->middleware('can:invite,group')->name('invite');

  Route::put('/create', 'GroupController@create')->middleware('can:create,App\Group')->name('create');
  Route::put('/{group}/update', 'GroupController@update')->middleware('can:update,App\Group')->name('update');
  Route::put('/{group}/leaveGroup','GroupController@leaveGroup')->middleware('can:leaveGroup,group')->name('leaveGroup');

  Route::put('/{group}/createInvite', 'InviteController@createInvite')->middleware('can:createInvite,group')->name('invites.createInvite');
  Route::put('/{group}/acceptInvite', 'InviteController@acceptInvite')->name('invites.acceptInvite');
  Route::put('/{group}/declineInvite', 'InviteController@declineInvite')->name('invites.declineInvite');
});

/* 
  Group Events:
  Group Events routes use policy middleware to check the Auth::user's privileges.
  Routes that don't require auth: index, join, decline, acceptInvite, declineInvite 
*/
Route::middleware('auth')->prefix('groups/{group}/events')->name('groups.events.')->group(function(){
  Route::get('/', 'GroupController@events')->middleware('can:events,group')->name('index');
  Route::get('/new','EventController@new')->middleware('can:newEvent,group')->name('new');

  Route::get('/{event}','EventController@view')->middleware('can:viewEvent,group')->name('view');
  Route::get('/{event}/edit','EventController@edit')->middleware('can:edit,event')->name('edit');
  Route::get('/{event}/delete','EventController@delete')->middleware('can:delete,event')->name('delete');
});

/* Events - Generic Events, no group required */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::get('/','EventController@index')->name('index');
  Route::get('/new','EventController@new')->middleware('can:new,App\Event')->name('new');
  Route::get('/{event}','EventController@event_redirect')->name('view');

  Route::put('/create', 'EventController@create')->middleware('can:new,App\Event')->name('create');
  Route::put('/{event}/attend','EventController@attend')->name('attend');
  Route::put('/{event}/update', 'EventController@update')->middleware('can:update,event')->name('update');
  Route::delete('/{event}/delete', 'EventController@destroy')->middleware('can:destroy,event')->name('destroy');

});

/* Users */
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
  Route::get('/{user}', 'UserController@view')->name('view');
});

/* My Profile */
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function(){
  Route::redirect('/','/home');
  Route::get('/edit','ProfileController@edit')->name('edit');
  Route::get('/password','ProfileController@password')->middleware('check-demo')->name('password');
  
  Route::put('/update', 'ProfileController@update')->name('update');
  Route::put('/updatePassword', 'ProfileController@updatePassword')->middleware('check-demo')->name('updatePassword');
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
