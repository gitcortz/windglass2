<?php

Route::get("/", "HomeController@dashboard");


//Customer Routes
Route::get("/customers", "CustomerController@index")->name("customers");