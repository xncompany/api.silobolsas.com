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

Route::get('/lands', 'LandController@listLands');
Route::get('/lands/{id_land}/silobags', 'SilobagController@listSilobags');
Route::get('/silobags/{id_silobag}/devices', 'DeviceController@listDevices');
Route::get('/devices/{id_device}/metrics', 'MetricController@listMetrics');
