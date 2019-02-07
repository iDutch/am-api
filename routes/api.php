<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/crossbar/clients', 'ApiController@getCrossbarClients');
    Route::get('/schedules', 'ScheduleController@index');
    Route::get('/schedule/{schedule}', 'ScheduleController@show')->where([
        'schedule' => '[0-9]+',
    ]);

    Route::post('/temperature', 'ApiController@logTemperature');
});
