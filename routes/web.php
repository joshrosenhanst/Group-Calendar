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
  Route::put('/delete', 'EventController@destroy');
});

/* Groups - member controls */
Route::group('groups', function(){
  Route::get('/', 'GroupController@index'); // my groups
  Route::get('/{group}', 'GroupController@view'); // view group
});

/* Admin controls */

Route::group('admin', function(){
  Route::group('groups', function(){
    Route::get('/{group}/edit', 'GroupController@view'); // view group    
  });
});

/* User management */

