<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// API
Route::get('api/v1/version', function () {
    return Response::json([
        'object' => [
            'server_version' => '1.2.3'
        ],
        'meta' => [
            'result' => 'ok'
        ]
    ]);
});

// Device Pairing
Route::post('api/v1/devices/link', 'DevicesController@startPairing');
Route::get('api/v1/devices/link/status/{token}', 'DevicesController@checkPairing');
