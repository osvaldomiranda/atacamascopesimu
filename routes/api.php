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
// Route::get('/moon_state', 'AstronomicObjectController@moon');


Route::get('/astronomic_objects/solarsistem', 'AstronomicObjectController@solarSistem');
Route::get('/astronomic_objects/horizon', 'AstronomicObjectController@horizon');

Route::get('/search_objects', 'AstronomicObjectController@search');

Route::post('/command/move', 'CommandController@move');
Route::post('/command/shoot', 'CommandController@shoot');
Route::post('/command/pointandshoot', 'CommandController@pointandshoot');
Route::post('/command/focus', 'CommandController@focus');

Route::get('/command/{type}', 'CommandController@command');


Route::get('/users', 'Api\V1\UsersController@index');
Route::get('/currentuser', 'Api\V1\UsersController@currentUser')->middleware('auth:api');

Route::post('messages', 'Api\V1\MessagesController@index');
Route::post('messages/send', 'Api\V1\MessagesController@store');

Route::get('image/last', 'ImageController@last');
Route::get('images', 'ImageController@index');

Route::get('points', 'PointsController@index')->middleware('auth:api');
Route::post('points/pay', 'PointsController@pay')->middleware('auth:api');

Route::get('/equipments', 'EquipmentController@index');
Route::get('/reservations', 'ReservationController@reservations');
Route::get('/my_reservations', 'ReservationController@myReservations')->middleware('auth:api');

Route::post('/reservation/create', 'ReservationController@create')->middleware('auth:api');

Route::post('/my_images', 'ImageController@myImages');

Route::get('/publications', 'PublicationController@publications');
Route::get('/offers', 'PublicationController@offers');

 Route::get('avatar', 'Api\V1\UsersController@avatar');
 Route::post('/save_avatar', 'Api\V1\UsersController@save_avatar')->middleware('auth:api');

 Route::get('weather', 'ExternalsController@weather');
 Route::get('weather_new', 'ExternalsController@weatherNew');

 Route::post('/equipment/save_image', 'EquipmentController@save_image');
 Route::post('/equipment/new', 'EquipmentController@new');


