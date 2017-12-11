<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/schedules', 'ApiController@getSchedules');
    Route::get('/schedules/{id}', 'ScheduleController@show')->where([
        'id' => '[0-9]+',
    ]);


    Route::get('/schedules', 'ScheduleController@index')->name('schedule.index');
    Route::prefix('schedule')->group(function () {
        Route::get('/create', 'ScheduleController@create')->name('schedule.create');
        Route::post('/store', 'ScheduleController@store');
        Route::get('/edit/{id}', 'ScheduleController@edit')->where(['id' => '[0-9]+'])->name('schedule.edit');
        Route::get('/{id}/entries', 'EntryController@index')->where(['id' => '[0-9]+'])->name('schedule.entries');
        Route::get('/{schedule_id}/entry/create', 'EntryController@create')->where(['schedule_id' => '[0-9]+'])->name('entry.create');
        Route::post('/{schedule_id}/entry/', 'ScheduleController@store')->where(['schedule_id' => '[0-9]+'])->name('entry.store');
        Route::get('/{schedule_id}/entry/edit/{id}', 'EntryController@edit')->where(['schedule_id' => '[0-9]+', 'id' => '[0-9]+'])->name('entry.edit');
    });

});