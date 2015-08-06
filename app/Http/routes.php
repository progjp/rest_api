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

Route::group(['prefix' => 'api/social', 'namespace' => 'Api\\Social'], function() {
    Route::post('people/{id}/add', 'PeopleController@add');

    Route::get('request', 'RequestController@index');
    Route::post('request/{id}/confirm', 'RequestController@confirm');
    Route::post('request/{id}/reject', 'RequestController@reject');

    Route::get('friend', 'FriendController@index');

    Route::get('connection', 'ConnectionController@index');
});
