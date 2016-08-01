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
            'server_version' => '1.2.3',
        ],
        'meta' => [
            'result' => 'ok',
        ],
    ]);
});

// Device Pairing
Route::get('/link', 'DevicesController@createPair');
Route::post('/link', 'DevicesController@storePair');

// Settings
Route::get('/settings/tokens', 'UsersController@tokens')->name('settings.tokens');

// API Routes
Route::post('api/v1/devices/link', 'Api\DeviceLinkController@startPairing');
Route::get('api/v1/devices/link/status/{token}', 'Api\DeviceLinkController@checkPairing');
