<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/schedules', 'ScheduleController@index')->name('schedule.index');
    Route::prefix('schedule')->group(function () {
        Route::get('/create', 'ScheduleController@create')->name('schedule.create');
        Route::post('/', 'ScheduleController@store')->name('schedule.store');
        Route::get('/edit/{id}', 'ScheduleController@edit')->where(['id' => '[0-9]+'])->name('schedule.edit');
        Route::patch('/update/{id}', 'ScheduleController@update')->where(['id' => '[0-9]+'])->name('schedule.update');
        Route::delete('/', 'ScheduleController@destroy')->name('schedule.delete');
        Route::get('/{id}/entries', 'EntryController@index')->where(['id' => '[0-9]+'])->name('schedule.entries');
        Route::get('/{schedule_id}/entry/create', 'EntryController@create')->where(['schedule_id' => '[0-9]+'])->name('entry.create');
        Route::post('/{schedule_id}/entry/', 'EntryController@store')->where(['schedule_id' => '[0-9]+'])->name('entry.store');
        Route::get('/{schedule_id}/entry/edit/{id}', 'EntryController@edit')->where(['schedule_id' => '[0-9]+', 'id' => '[0-9]+'])->name('entry.edit');
        Route::patch('/{schedule_id}/entry/update/{id}', 'EntryController@update')->where(['schedule_id' => '[0-9]+', 'id' => '[0-9]+'])->name('entry.update');
    });
});

Auth::routes();
