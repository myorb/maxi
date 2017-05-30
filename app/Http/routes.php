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

Route::get('/f', function () {
    var_dump(explode("\n",Storage::get(DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'proxy_list.txt')));
//    return view('welcome');
});

Route::get('/hello', function () {
    return view('info',array('slot' => 'MEDVED'));
});

Route::resource('/', 'ElevatorController');
Route::resource('mail', 'ElevatorController@mail');
Route::resource('urls', 'ElevatorController@urls');
Route::resource('site', 'SiteController');

