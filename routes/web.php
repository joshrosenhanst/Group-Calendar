<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('login');
  //if auth, go to group home page
  //else go to login page
});

/* Calendar */
Route::get('/calendar','EventController@calendar');

/* Events */
Route::group('events', function(){
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
Route::group('groups', function(){
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
Route::group('profile', function(){
  Route::get('/','ProfileController@index'); // my profile
  Route::get('/edit','EventController@edit');
  Route::put('/update', 'EventController@update');
});

/* Comments */
Route::group('comments', function(){
  Route::put('/create', 'CommentController@create');
  Route::put('/update', 'CommentController@update');
  Route::delete('/delete', 'CommentController@destroy');
});