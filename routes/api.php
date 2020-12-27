<?php

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/importStarship','StarshipController@importStarship');
Route::get('/starships/{id}','StarshipController@getStarship');
Route::put('/starships/{id}/set/{number}','StarshipController@setQuantity');
Route::put('/starships/{id}/increment','StarshipController@increment');
Route::put('/starships/{id}/decrement','StarshipController@decrement');



Route::get('/importVehicles','VehicleController@importVehicles');
Route::get('/vehicle/{id}','VehicleController@getVehicle');
Route::put('/vehicle/{id}/set/{number}','VehicleController@setQuantity');
Route::put('/vehicle/{id}/increment','VehicleController@increment');
Route::put('/vehicle/{id}/decrement','VehicleController@decrement');