<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'landing'])->name('landing');
Route::get('/home', [LoginController::class, 'home'])->name('home')->middleware('auth');
Route::get('/demo', [LoginController::class, 'demo'])->name('demo');
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/* New User Invitations */
Route::get('/register', [InviteController::class, 'register'])->name('register')->middleware('guest');
Route::put('/submitRegistration', [InviteController::class, 'submitRegistration'])->name('submitRegistration')->middleware('guest');

/* Group Invitations List */
Route::get('/invitations', [InviteController::class, 'index'])->name('invitations')->middleware('auth');

/* 
  Groups:
  Group routes use policy middleware to check the Auth::user's privileges.
  Routes that don't require auth: index, join, decline, acceptInvite, declineInvite
*/
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function(){
  Route::get('/', [GroupController::class, 'index'])->name('index'); // my groups
  Route::get('/new', [GroupController::class, 'new'])->middleware('can:new,App\Group')->name('new');

  Route::get('/{group}', [GroupController::class, 'view'])->middleware('can:view,group')->name('view');
  Route::get('/{group}/members', [GroupController::class, 'members'])->middleware('can:members,group')->name('members');
  Route::get('/{group}/leave', [GroupController::class, 'leave'])->middleware('can:leave,group')->name('leave');
  Route::get('/{group}/edit', [GroupController::class, 'edit'])->middleware('can:edit,group')->name('edit');

  Route::get('/{group}/join', [InviteController::class, 'join'])->name('invites.join');
  Route::get('/{group}/decline', [InviteController::class, 'decline'])->name('invites.decline');
  Route::get('/{group}/invite', [InviteController::class, 'invite'])->middleware('can:invite,group')->name('invite');

  Route::put('/create', [GroupController::class, 'create'])->middleware('can:create,App\Group')->name('create');
  Route::put('/{group}/update', [GroupController::class, 'update'])->middleware('can:update,group')->name('update');
  Route::put('/{group}/leaveGroup', [GroupController::class, 'leaveGroup'])->middleware('can:leaveGroup,group')->name('leaveGroup');

  Route::put('/{group}/createInvite', [InviteController::class, 'createInvite'])->middleware('can:createInvite,group')->name('invites.createInvite');
  Route::put('/{group}/acceptInvite', [InviteController::class, 'acceptInvite'])->name('invites.acceptInvite');
  Route::put('/{group}/declineInvite', [InviteController::class, 'declineInvite'])->name('invites.declineInvite');

  Route::put('/{group}/createComment', [GroupController::class, 'createComment'])->middleware('can:createComment,group')->name('createComment');
});

/* 
  Group Events:
  Group Events routes use policy middleware to check the Auth::user's privileges.
  Routes that don't require auth: index, join, decline, acceptInvite, declineInvite 
*/
Route::middleware('auth')->prefix('groups/{group}/events')->name('groups.events.')->group(function(){
  Route::get('/', [GroupController::class, 'events'])->middleware('can:events,group')->name('index');
  Route::get('/new', [EventController::class, 'new'])->middleware('can:newEvent,group')->name('new');

  Route::get('/{event}', [EventController::class, 'view'])->middleware('can:viewEvent,group')->name('view');
  Route::get('/{event}/edit', [EventController::class, 'edit'])->middleware('can:edit,event')->name('edit');
  Route::get('/{event}/delete', [EventController::class, 'delete'])->middleware('can:delete,event')->name('delete');
});

/* Events - Generic Events, no group required */
Route::middleware('auth')->prefix('events/')->name('events.')->group(function(){
  Route::get('/', [EventController::class, 'index'])->name('index');
  Route::get('/new', [EventController::class, 'new'])->middleware('can:new,App\Event')->name('new');
  Route::get('/{event}', [EventController::class, 'event_redirect'])->middleware('can:view,event')->name('view');

  Route::put('/create', [EventController::class, 'create'])->middleware('can:new,App\Event')->name('create');
  Route::put('/{event}/attend', [EventController::class, 'attend'])->middleware('can:attend,event')->name('attend');
  Route::put('/{event}/update', [EventController::class, 'update'])->middleware('can:update,event')->name('update');
  Route::delete('/{event}/delete', [EventController::class, 'destroy'])->middleware('can:destroy,event')->name('destroy');

  Route::put('/{event}/createComment', [EventController::class, 'createComment'])->middleware('can:createComment,event')->name('createComment');

});

/* Users */
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
  Route::get('/{user}', [UserController::class, 'view'])->name('view');
});

/* My Profile */
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function(){
  Route::redirect('/','/home');
  Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
  Route::get('/password', [ProfileController::class, 'password'])->middleware('check-demo')->name('password');
  
  Route::put('/update', [ProfileController::class, 'update'])->name('update');
  Route::put('/updatePassword', [ProfileController::class, 'updatePassword'])->middleware('check-demo')->name('updatePassword');
});

/* Notifications */
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function(){
  Route::get('/', [NotificationController::class, 'index'])->name('index');
});

/* Comments */
// Route::middleware('auth')->prefix('comments')->name('comments.')->group(function(){
//   Route::put('/create', [CommentController::class, 'create'])->name('create');
//   Route::put('/update', [CommentController::class, 'update'])->name('update');
//   Route::delete('/delete', [CommentController::class, 'destroy'])->name('destroy');
// });
