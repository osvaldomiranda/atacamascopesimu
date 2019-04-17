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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload', 'ImageController@upload');
Route::get('/astronomic_objects', 'AstronomicObjectController@index');

Route::post('/command/move', 'CommandController@move');
Route::post('/command/shoot', 'CommandController@shoot');
Route::post('/command/focus', 'CommandController@focus');