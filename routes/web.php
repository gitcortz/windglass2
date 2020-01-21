<?php

Route::get("/", "HomeController@dashboard");


//Customer Routes 
Route::get("/customers", "CustomerController@index")->name("customers");
Route::get("/customer/all", "CustomerController@list")->name("customer-list");
Route::group(['prefix' => 'customers'], function () {
    Route::get('/{id}', [
        'uses' => 'CustomerController@show',
        'as'   => 'customers.show',
    ]);

    Route::post('/', [
        'uses' => 'CustomerController@store',
        'as'   => 'customers.store',
    ]);

    Route::put('/{id}', [
        'uses' => 'CustomerController@update',
        'as'   => 'customers.update',
    ]);

    Route::delete('/{id}', [
        'uses' => 'CustomerController@destroy',
        'as'   => 'customers.destroy',
    ]);
});