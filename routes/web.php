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
    Route::get('/{id}/products', 'BranchController@products');
});


//Brands Routes 
Route::group(['prefix' => 'brands'], function () {
    Route::get('', [ 'uses' => 'BrandController@index', 'as' => 'brands',]);
    Route::get('/all', [ 'uses' => 'BrandController@list', 'as' => 'brands.list',]);
    Route::get('/{id}', [ 'uses' => 'BrandController@show', 'as' => 'brands.show',]);
    Route::post('/', [ 'uses' => 'BrandController@store', 'as' => 'brands.store',]);
    Route::put('/{id}', [ 'uses' => 'BrandController@update', 'as' => 'brands.update',]);
    Route::delete('/{id}', [ 'uses' => 'BrandController@destroy', 'as'   => 'brands.destroy',]);
});


//Product Types Routes 
Route::group(['prefix' => 'producttypes'], function () {
    Route::get('', [ 'uses' => 'ProductTypeController@index', 'as' => 'producttypes',]);
    Route::get('/all', [ 'uses' => 'ProductTypeController@list', 'as' => 'producttypes.list',]);
    Route::get('/{id}', [ 'uses' => 'ProductTypeController@show', 'as' => 'producttypes.show',]);
    Route::post('/', [ 'uses' => 'ProductTypeController@store', 'as' => 'producttypes.store',]);
    Route::put('/{id}', [ 'uses' => 'ProductTypeController@update', 'as' => 'producttypes.update',]);
    Route::delete('/{id}', [ 'uses' => 'ProductTypeController@destroy', 'as'   => 'producttypes.destroy',]);
});


//Product Routes 
Route::group(['prefix' => 'products'], function () {
    Route::get('', [ 'uses' => 'ProductController@index', 'as' => 'products',]);
    Route::get('/all', [ 'uses' => 'ProductController@list', 'as' => 'products.list',]);
    Route::get('/{id}', [ 'uses' => 'ProductController@show', 'as' => 'products.show',]);
    Route::post('/', [ 'uses' => 'ProductController@store', 'as' => 'products.store',]);
    Route::put('/{id}', [ 'uses' => 'ProductController@update', 'as' => 'products.update',]);
    Route::delete('/{id}', [ 'uses' => 'ProductController@destroy', 'as'   => 'products.destroy',]);
});


//Stock Routes 
Route::group(['prefix' => 'stocks'], function () {
    Route::get('', [ 'uses' => 'StockController@index', 'as' => 'stocks',]);
    Route::get('/all', [ 'uses' => 'StockController@list', 'as' => 'stocks.list',]);
    Route::get('/{id}', [ 'uses' => 'StockController@show', 'as' => 'stocks.show',]);
    Route::post('/', [ 'uses' => 'StockController@store', 'as' => 'stocks.store',]);
    Route::put('/{id}', [ 'uses' => 'StockController@update', 'as' => 'stocks.update',]);
    Route::delete('/{id}', [ 'uses' => 'StockController@destroy', 'as'   => 'stocks.destroy',]);
});


//StockTransfer Routes 
Route::group(['prefix' => 'stocktransfers'], function () {
    Route::get('', [ 'uses' => 'StockTransferController@index', 'as' => 'stocktransfers',]);
    Route::get('/all', [ 'uses' => 'StockTransferController@list', 'as' => 'stocktransfers.list',]);
    Route::get('/{id}', [ 'uses' => 'StockTransferController@show', 'as' => 'stocktransfers.show',]);
    Route::post('/', [ 'uses' => 'StockTransferController@store', 'as' => 'stocktransfers.store',]);
    Route::put('/{id}', [ 'uses' => 'StockTransferController@update', 'as' => 'stocktransfers.update',]);
    Route::delete('/{id}', [ 'uses' => 'StockTransferController@destroy', 'as'   => 'stocktransfers.destroy',]);
});

//StockTransfer Routes 
Route::group(['prefix' => 'stocktransferitems'], function () {
    Route::get('', [ 'uses' => 'StockTransferItemController@index', 'as' => 'stocktransferitems',]);
    Route::get('/all', [ 'uses' => 'StockTransferItemController@list', 'as' => 'stocktransferitems.list',]);
    Route::get('/{id}', [ 'uses' => 'StockTransferItemController@show', 'as' => 'stocktransferitems.show',]);
    Route::post('/', [ 'uses' => 'StockTransferItemController@store', 'as' => 'stocktransferitems.store',]);
    Route::put('/{id}', [ 'uses' => 'StockTransferItemController@update', 'as' => 'stocktransferitems.update',]);
    Route::delete('/{id}', [ 'uses' => 'StockTransferItemController@destroy', 'as'   => 'stocktransferitems.destroy',]);
});