<?php

// ======= Organizations
Route::get('/organizations', 'OrganizationsController@list');
Route::get('/organizations/{id_organization}/users', 'OrganizationsController@users');
Route::post('/organizations', 'OrganizationsController@create');
Route::delete('/organizations/{id_organization}', 'OrganizationsController@delete');


// ======= Metrics

Route::get('/configurations', 'ConfigurationsController@getMetrics');
Route::post('/configurations', 'ConfigurationsController@setMetrics');

// ======= Users

Route::get('/users/{id_user}', 'UserController@getById');
Route::post('/users/{id_user}/password', 'UserController@resetPassword');
Route::post('/users', 'UserController@create');
Route::delete('/users/{id_user}', 'UserController@delete');
Route::post('/login', 'UserController@getByEmailAndPassword');

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
Route::delete('/devices/{id_device}', 'DeviceController@delete');
Route::post('/devices', 'DeviceController@create');

// ======= Alerts

Route::post('/alerts', 'AlertController@createAlert');
Route::put('/alerts/{id_alert}', 'AlertController@updateAlert');

// ======= Dashboard

Route::get('/dashboard', 'DashboardController@list');