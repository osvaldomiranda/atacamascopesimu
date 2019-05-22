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

Route::post('/upload/{command_id}', 'ImageController@upload');
Route::get('/astronomic_objects', 'AstronomicObjectController@index');
Route::get('/astronomic_objects/coords', 'AstronomicObjectController@coords');
Route::get('/moon_state', 'AstronomicObjectController@moon');


Route::get('/astronomic_objects/solarsistem', 'AstronomicObjectController@solarSistem');

Route::post('/command/move', 'CommandController@move');
Route::post('/command/shoot', 'CommandController@shoot');
Route::post('/command/focus', 'CommandController@focus');

Route::get('/command/{type}', 'CommandController@command');


Route::get('users', 'Api\V1\UsersController@index');
Route::post('messages', 'Api\V1\MessagesController@index');
Route::post('messages/send', 'Api\V1\MessagesController@store');

Route::get('image/last', 'ImageController@last');
Route::get('images', 'ImageController@index');

Route::get('points', 'PointsController@index');
Route::post('points/pay', 'PointsController@pay');

Route::post('/equipments', 'EquipmentController@index');
Route::post('/reservations', 'ReservationController@index');
Route::post('/my_reservations', 'ReservationController@myReservations');

Route::post('/my_images', 'ImageController@myImages');

