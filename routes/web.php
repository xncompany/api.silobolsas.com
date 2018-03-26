<?php

// ======= Users

Route::get('/users/{id_user}', 'UserController@getById');
Route::get('/users/{id_user}/lands', 'UserController@listLands');

// ======= Lands

Route::get('/lands', 'LandController@listLands');
Route::post('/lands', 'LandController@createLand');
Route::get('/lands/{id_land}/silobags', 'SilobagController@listSilobags');
Route::delete('/lands/{id_land}', 'LandController@delete');

// ======= Silobags

Route::post('/silobags', 'SilobagController@createSilobag');
Route::get('/silobags/{id_silobag}', 'SilobagController@getSilobag');
Route::put('/silobags/{id_silobag}', 'SilobagController@updateSilobag');
Route::get('/silobags/{id_silobag}/devices', 'DeviceController@listDevices');
Route::delete('/silobags/{id_silobag}', 'SilobagController@delete');

// ======= Devices

Route::get('/devices/{id_device}/metrics', 'MetricController@listMetrics');
Route::get('/devices/{id_device}', 'DeviceController@getDevice');
Route::put('/devices/{id_device}', 'DeviceController@updateDevice');
Route::get('/devices/{id_device}/alerts', 'AlertController@listAlerts');

// ======= Alerts

Route::post('/alerts', 'AlertController@createAlert');
Route::put('/alerts/{id_alert}', 'AlertController@updateAlert');
