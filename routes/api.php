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
Route::post('/lands', 'LandController@createLand');
Route::get('/lands/{id_land}/silobags', 'SilobagController@listSilobags');
Route::post('/silobags', 'SilobagController@createSilobag');
Route::get('/silobags/{id_silobag}', 'SilobagController@getSilobag');
Route::put('/silobags/{id_silobag}', 'SilobagController@updateSilobag');
Route::get('/silobags/{id_silobag}/devices', 'DeviceController@listDevices');
Route::get('/devices/{id_device}/metrics', 'MetricController@listMetrics');
Route::get('/devices/{id_device}', 'DeviceController@getDevice');
Route::put('/devices/{id_device}', 'DeviceController@updateDevice');
Route::get('/devices/{id_device}/alerts', 'AlertController@listAlerts');
