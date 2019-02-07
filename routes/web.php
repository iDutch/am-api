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
        Route::get('/edit/{schedule}', 'ScheduleController@edit')->where(['schedule' => '[0-9]+'])->name('schedule.edit');
        Route::patch('/update/{schedule}', 'ScheduleController@update')->where(['schedule' => '[0-9]+'])->name('schedule.update');
        Route::delete('/', 'ScheduleController@destroy')->name('schedule.delete');
        Route::get('/{schedule}/entries', 'EntryController@index')->where(['schedule' => '[0-9]+'])->name('schedule.entries');
        Route::get('/{schedule}/entry/create', 'EntryController@create')->where(['schedule' => '[0-9]+'])->name('entry.create');
        Route::post('/{schedule/entry/', 'EntryController@store')->where(['schedule' => '[0-9]+'])->name('entry.store');
        Route::get('/{schedule}/entry/edit/{entry}', 'EntryController@edit')->where(['schedule' => '[0-9]+', 'entry' => '[0-9]+'])->name('entry.edit');
        Route::patch('/{schedule}/entry/update/{entry}', 'EntryController@update')->where(['schedule' => '[0-9]+', 'entry' => '[0-9]+'])->name('entry.update');
        Route::delete('/{schedule}/entry/', 'EntryController@destroy')->where(['schedule' => '[0-9]+'])->name('entry.delete');
    });
});

Auth::routes();
