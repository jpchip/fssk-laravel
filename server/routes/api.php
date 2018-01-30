<?php

use Illuminate\Http\Request;

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

Route::post('/auth', 'AuthController@index');

Route::delete('/auth', 'AuthController@logout');

Route::middleware('auth:api')->group(function () {

	Route::get('/auth', function (Request $request) {
		return Auth::guard('api')->user();
	});

	Route::apiResource('users', 'UserController');
	Route::apiResource('todos', 'TodoController');

});
