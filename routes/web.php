<?php

//Auth::routes();

Route::get('/', 'LoginController@landing')->name('landing');
//Route::get('/login', 'HomeController@login')->name('login');
Route::get('/home', 'LoginController@home')->name('home')->middleware('auth');
Route::get('/demo', 'LoginController@demo')->name('demo');
Route::get('/login', 'LoginController@login')->name('login')->middleware('guest');
Route::post('/authenticate', 'LoginController@authenticate')->name('authenticate');
Route::get('/logout', 'LoginController@logout')->name('logout');

/* Calendar */
Route::get('/calendar','EventController@calendar');

/* Events */
Route::prefix('events')->group(function(){
  Route::get('/','EventController@index');
  Route::get('/new','EventController@new');
  Route::get('/{event}','EventController@view');
  Route::get('/{event}/edit','EventController@edit');
  Route::get('/{event}/delete','EventController@delete');
  Route::put('/create', 'EventController@create');
  Route::put('/update', 'EventController@update');
  Route::delete('/delete', 'EventController@destroy');
});

/* Groups */
Route::prefix('groups')->group(function(){
  Route::get('/', 'GroupController@index'); // my groups
  Route::get('/{group}', 'GroupController@view'); // view group
  Route::get('/new','GroupController@new');
  Route::get('/{group}/edit','GroupController@edit');
  Route::get('/{group}/delete','GroupController@delete');
  Route::get('/{group}/invite','GroupController@invite');
  Route::get('/{group}/join','GroupController@join');
  Route::put('/create', 'GroupController@create');
  Route::put('/sendInvite', 'GroupController@sendInvite');
  Route::put('/acceptInvite', 'GroupController@acceptInvite');
  Route::put('/update', 'GroupController@update');
  Route::delete('/delete', 'GroupController@destroy');
});

/* My Profile */
Route::prefix('profile')->group(function(){
  Route::get('/','ProfileController@index'); // my profile
  Route::get('/edit','EventController@edit');
  Route::put('/update', 'EventController@update');
});

/* Comments */
Route::prefix('comments')->group(function(){
  Route::put('/create', 'CommentController@create');
  Route::put('/update', 'CommentController@update');
  Route::delete('/delete', 'CommentController@destroy');
});
