<?php

Route::get("/", "HomeController@dashboard");
 

//Customer Routes 
Route::group(['prefix' => 'customers'], function () {
    Route::get('', [ 'uses' => 'CustomerController@index', 'as' => 'customers',]);
    Route::get('/all', [ 'uses' => 'CustomerController@list', 'as' => 'customers.list',]);
    Route::get('/{id}', [ 'uses' => 'CustomerController@show', 'as' => 'customers.show',]);
    Route::post('/', [ 'uses' => 'CustomerController@store', 'as' => 'customers.store',]);
    Route::put('/{id}', [ 'uses' => 'CustomerController@update', 'as' => 'customers.update',]);
    Route::delete('/{id}', [ 'uses' => 'CustomerController@destroy', 'as'   => 'customers.destroy',]);
});