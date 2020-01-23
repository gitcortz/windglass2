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

//Cities Routes 
Route::group(['prefix' => 'cities'], function () {
    Route::get('', [ 'uses' => 'CityController@index', 'as' => 'cities',]);
    Route::get('/all', [ 'uses' => 'CityController@list', 'as' => 'cities.list',]);
    Route::get('/{id}', [ 'uses' => 'CityController@show', 'as' => 'cities.show',]);
    Route::post('/', [ 'uses' => 'CityController@store', 'as' => 'cities.store',]);
    Route::put('/{id}', [ 'uses' => 'CityController@update', 'as' => 'cities.update',]);
    Route::delete('/{id}', [ 'uses' => 'CityController@destroy', 'as'   => 'cities.destroy',]);
});


//Branches Routes 
Route::group(['prefix' => 'branches'], function () {
    Route::get('', [ 'uses' => 'BranchController@index', 'as' => 'branches',]);
    Route::get('/all', [ 'uses' => 'BranchController@list', 'as' => 'branches.list',]);
    Route::get('/{id}', [ 'uses' => 'BranchController@show', 'as' => 'branches.show',]);
    Route::post('/', [ 'uses' => 'BranchController@store', 'as' => 'branches.store',]);
    Route::put('/{id}', [ 'uses' => 'BranchController@update', 'as' => 'branches.update',]);
    Route::delete('/{id}', [ 'uses' => 'BranchController@destroy', 'as'   => 'branches.destroy',]);
});