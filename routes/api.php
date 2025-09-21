<?php

use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});*/

/* EVENTS */
Route::middleware('auth:api')->prefix('events/')->name('events.')->group(function(){
	Route::get('/', [EventController::class, 'index'])->name('index');
  Route::get('/{event}', [EventController::class, 'view'])->name('view');
});
