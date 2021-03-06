<?php
Route::group(['middleware' => 'not.auth'], function () {
    Route::get("/", "HomeController@dashboard");

    //Cities Routes 
    Route::group(['prefix' => 'cities'], function () {
        Route::get('', [ 'uses' => 'CityController@index', 'as' => 'cities',]);
        Route::get('/all', [ 'uses' => 'CityController@list', 'as' => 'cities.list',]);
        Route::get('/{id}', [ 'uses' => 'CityController@show', 'as' => 'cities.show',]);
        Route::post('/', [ 'uses' => 'CityController@store', 'as' => 'cities.store',]);
        Route::put('/{id}', [ 'uses' => 'CityController@update', 'as' => 'cities.update',]);
        Route::delete('/{id}', [ 'uses' => 'CityController@destroy', 'as'   => 'cities.destroy',]);
    });

        
    //Customer Routes 
    Route::group(['prefix' => 'customers'], function () {
        Route::get('', [ 'uses' => 'CustomerController@index', 'as' => 'customers',]);
        Route::get('/all', [ 'uses' => 'CustomerController@list', 'as' => 'customers.list',]);
        Route::get('/search', [ 'uses' => 'CustomerController@search', 'as' => 'customers.search',]);
        Route::get('/combo', [ 'uses' => 'CustomerController@combo_list', 'as' => 'customers.combolist',]);
        Route::get('/{id}', [ 'uses' => 'CustomerController@show', 'as' => 'customers.show',]);
        Route::post('/', [ 'uses' => 'CustomerController@store', 'as' => 'customers.store',]);
        Route::put('/{id}', [ 'uses' => 'CustomerController@update', 'as' => 'customers.update',]);
        Route::delete('/{id}', [ 'uses' => 'CustomerController@destroy', 'as'   => 'customers.destroy',]);        
    });




    //Branches Routes 
    Route::group(['prefix' => 'branches'], function () {
        Route::get('', [ 'uses' => 'BranchController@index', 'as' => 'branches',]);
        Route::get('/all', [ 'uses' => 'BranchController@list', 'as' => 'branches.list',]);
        Route::get('/session', [ 'uses' => 'BranchController@session', 'as'   => 'branches.session',]);
        Route::get('/switch/{branch_id}', [ 'uses' => 'AdminController@set_branch', 'as'   => 'branches.switch',]);                
        Route::get('/{id}', [ 'uses' => 'BranchController@show', 'as' => 'branches.show',]);
        Route::post('/', [ 'uses' => 'BranchController@store', 'as' => 'branches.store',]);
        Route::put('/{id}', [ 'uses' => 'BranchController@update', 'as' => 'branches.update',]);
        Route::delete('/{id}', [ 'uses' => 'BranchController@destroy', 'as'   => 'branches.destroy',]);
        Route::get('/{id}/products', 'BranchController@products');
        Route::get('/{id}/emptycylinders', 'BranchController@empty_cylinders');
        
    });

    //Brands Routes 1
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
        Route::get('/{id}/movements', 'StockController@movements');
        Route::post('/add_movement', 'StockController@add_movement');
    });


    //StockTransfer Routes 
    Route::group(['prefix' => 'stocktransfers'], function () {
        Route::get('', [ 'uses' => 'StockTransferController@index', 'as' => 'stocktransfers',]);
        Route::get('/all', [ 'uses' => 'StockTransferController@list', 'as' => 'stocktransfers.list',]);
        Route::get('/{id}', [ 'uses' => 'StockTransferController@show', 'as' => 'stocktransfers.show',]);
        Route::post('/', [ 'uses' => 'StockTransferController@store', 'as' => 'stocktransfers.store',]);
        Route::put('/{id}', [ 'uses' => 'StockTransferController@update', 'as' => 'stocktransfers.update',]);
        Route::delete('/{id}', [ 'uses' => 'StockTransferController@destroy', 'as'   => 'stocktransfers.destroy',]);
        Route::get('/{id}/items', 'StockTransferController@items');
        Route::post('/{id}/transfer', 'StockTransferController@transfer');
        Route::post('/{id}/receive', 'StockTransferController@receive');
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

    //POS Routes 
    Route::group(['prefix' => 'pos'], function () {
        Route::get('', [ 'uses' => 'PosController@index', 'as' => 'pos',]);
        Route::get('/v2', [ 'uses' => 'PosController@index_v2', 'as' => 'pos-v2',]);
        Route::get('/receipt/{id}', [ 'uses' => 'PosController@receipt', 'as' => 'pos.receipt',]);
        Route::get('/{id}/list', [ 'uses' => 'PosController@list', 'as' => 'pos.list',]);
        Route::get('/session', [ 'uses' => 'PosController@session', 'as' => 'pos.session',]);
    });


    //Order Routes 
    Route::group(['prefix' => 'orders'], function () {
        Route::get('', [ 'uses' => 'OrderController@index', 'as' => 'orders',]);
        Route::post('/', [ 'uses' => 'OrderController@store', 'as' => 'orders.store',]);
        Route::put('/{id}', [ 'uses' => 'OrderController@update', 'as' => 'orders.update',]);
    });


    //Employee Types Routes 
    Route::group(['prefix' => 'employeetypes'], function () {
        Route::get('', [ 'uses' => 'EmployeeTypeController@index', 'as' => 'employeetypes',]);
        Route::get('/all', [ 'uses' => 'EmployeeTypeController@list', 'as' => 'employeetypes.list',]);
        Route::get('/{id}', [ 'uses' => 'EmployeeTypeController@show', 'as' => 'employeetypes.show',]);
        Route::post('/', [ 'uses' => 'EmployeeTypeController@store', 'as' => 'employeetypes.store',]);
        Route::put('/{id}', [ 'uses' => 'EmployeeTypeController@update', 'as' => 'employeetypes.update',]);
        Route::delete('/{id}', [ 'uses' => 'EmployeeTypeController@destroy', 'as'   => 'employeetypes.destroy',]);
    });

    
    //Expenses Routes 
    Route::group(['prefix' => 'expenses'], function () {
        Route::get('', [ 'uses' => 'ExpenseController@index', 'as' => 'expenses',]);
        Route::get('/all', [ 'uses' => 'ExpenseController@list', 'as' => 'expenses.list',]);
        Route::get('/{id}', [ 'uses' => 'ExpenseController@show', 'as' => 'expenses.show',]);
        Route::post('/', [ 'uses' => 'ExpenseController@store', 'as' => 'expenses.store',]);
        Route::put('/{id}', [ 'uses' => 'ExpenseController@update', 'as' => 'expenses.update',]);
        Route::delete('/{id}', [ 'uses' => 'ExpenseController@destroy', 'as'   => 'expenses.destroy',]);
    });

    //Employee Routes 
    Route::group(['prefix' => 'employees'], function () {
        Route::get('', [ 'uses' => 'EmployeeController@index', 'as' => 'employees',]);
        Route::get('/all', [ 'uses' => 'EmployeeController@list', 'as' => 'employees.list',]);
        Route::get('/combo', [ 'uses' => 'EmployeeController@combo_list', 'as' => 'employees.combolist',]);
        Route::get('/riders', [ 'uses' => 'EmployeeController@riders', 'as' => 'employees.riders',]);
        Route::get('/{id}', [ 'uses' => 'EmployeeController@show', 'as' => 'employees.show',]);
        Route::post('/', [ 'uses' => 'EmployeeController@store', 'as' => 'employees.store',]);
        Route::put('/{id}', [ 'uses' => 'EmployeeController@update', 'as' => 'employees.update',]);
        Route::delete('/{id}', [ 'uses' => 'EmployeeController@destroy', 'as'   => 'employees.destroy',]);
        Route::get('/{id}/loans', 'EmployeeController@loans');
    });


    //Employee Loans Routes 
    Route::group(['prefix' => 'employeeloans'], function () {
        Route::get('', [ 'uses' => 'EmployeeLoanController@index', 'as' => 'employeeloans',]);
        Route::get('/all', [ 'uses' => 'EmployeeLoanController@list', 'as' => 'employeeloans.list',]);
        Route::get('/{id}', [ 'uses' => 'EmployeeLoanController@show', 'as' => 'employeeloans.show',]);
        Route::post('/', [ 'uses' => 'EmployeeLoanController@store', 'as' => 'employeeloans.store',]);
        Route::put('/{id}', [ 'uses' => 'EmployeeLoanController@update', 'as' => 'employeeloans.update',]);
        Route::delete('/{id}', [ 'uses' => 'EmployeeLoanController@destroy', 'as'   => 'employeeloans.destroy',]);
        Route::post('/{id}/approve', [ 'uses' => 'EmployeeLoanController@approve', 'as'   => 'employeeloans.approve',]);
    });


    //Timesheet Detail Routes 
    Route::group(['prefix' => 'timesheetdetails'], function () {
        Route::get('', [ 'uses' => 'TimesheetDetailController@index', 'as' => 'timesheetdetails',]);
        Route::get('/all', [ 'uses' => 'TimesheetDetailController@list', 'as' => 'timesheetdetails.list',]);
        Route::get('/{id}', [ 'uses' => 'TimesheetDetailController@show', 'as' => 'timesheetdetails.show',]);
        Route::post('/', [ 'uses' => 'TimesheetDetailController@store', 'as' => 'timesheetdetails.store',]);
        Route::put('/{id}', [ 'uses' => 'TimesheetDetailController@update', 'as' => 'timesheetdetails.update',]);
        Route::delete('/{id}', [ 'uses' => 'TimesheetDetailController@destroy', 'as'   => 'timesheetdetails.destroy',]);
        Route::post('/upload', [ 'uses' => 'TimesheetDetailController@upload', 'as'   => 'timesheetdetails.upload',]);
    });

    //Payroll Routes 
    Route::group(['prefix' => 'payrolls'], function () {
        Route::get('', [ 'uses' => 'PayrollController@index', 'as' => 'payrolls',]);
        Route::get('/all', [ 'uses' => 'PayrollController@list', 'as' => 'payrolls.list',]);
        Route::get('/export', [ 'uses' => 'PayrollController@export', 'as' => 'payrolls.export',]);
        Route::get('/{id}', [ 'uses' => 'PayrollController@show', 'as' => 'payrolls.show',]);
        Route::post('/', [ 'uses' => 'PayrollController@store', 'as' => 'payrolls.store',]);
        Route::put('/{id}', [ 'uses' => 'PayrollController@update', 'as' => 'payrolls.update',]);
        Route::delete('/{id}', [ 'uses' => 'PayrollController@destroy', 'as'   => 'payrolls.destroy',]);
        Route::post('/generate', [ 'uses' => 'PayrollController@generate', 'as'   => 'payrolls.generate',]);
        Route::post('/approve', [ 'uses' => 'PayrollController@approve', 'as'   => 'payrolls.approve',]);
    });

    //daily sales Routes 
    Route::group(['prefix' => 'reports'], function () {
        Route::get('', [ 'uses' => 'ReportController@index', 'as' => 'reports',]);
        Route::get('/dailysales', [ 'uses' => 'ReportController@dailysalesindex', 'as' => 'reportdailysales',]);    
        Route::get('/dailysalesreport', [ 'uses' => 'ReportController@dailysalesreport', 'as' => 'dailysalesreport',]);    
        Route::get('/dailysalesreport/pdf', [ 'uses' => 'ReportController@dailysalesreportpdf', 'as' => 'dailysalesreportpdf',]);    
        Route::get('/dailysalesreport/excel', [ 'uses' => 'ReportController@dailysalesreportexcel', 'as' => 'dailysalesreportexcel',]);    
        Route::get('/loans', [ 'uses' => 'ReportController@loansindex', 'as' => 'reportloans',]);    
        Route::get('/loansreport', [ 'uses' => 'ReportController@loansreport', 'as' => 'loansreport',]);    
        Route::get('/loansreport/export', [ 'uses' => 'ReportController@loansreportexport', 'as' => 'loansreportexport',]);    
        Route::get('/pendingorder', [ 'uses' => 'ReportController@pendingorderindex', 'as' => 'reportpendingorder',]);    
        Route::get('/{id}/pendingorderreport', [ 'uses' => 'ReportController@pendingorderreport', 'as' => 'pendingorderreport',]);    
        Route::get('/expenses', [ 'uses' => 'ReportController@expensesindex', 'as' => 'reportexpenses',]);    
        Route::get('/expensesreport', [ 'uses' => 'ReportController@expensesreport', 'as' => 'expensesreport',]);    
        Route::get('/expensesreport/excel', [ 'uses' => 'ReportController@expensesreportexcel', 'as' => 'expensesreportexcel',]);    
    });



    //Users Routes 
    Route::group(['prefix' => 'users'], function () {
        Route::get('', [ 'uses' => 'UserController@index', 'as' => 'users',]);
        Route::get('/all', [ 'uses' => 'UserController@list', 'as' => 'users.list',]);
        Route::get('/{id}', [ 'uses' => 'UserController@show', 'as' => 'users.show',]);
        Route::post('/', [ 'uses' => 'UserController@store', 'as' => 'users.store',]);
        Route::put('/{id}', [ 'uses' => 'UserController@update', 'as' => 'users.update',]);
        Route::delete('/{id}', [ 'uses' => 'UserController@destroy', 'as'   => 'users.destroy',]);
        Route::get('/{id}/branches', [ 'uses' => 'UserController@branches', 'as'   => 'users.branches',]);
    });

   
});



Route::get('/login', [ 'uses' => 'AdminController@adminLoginForm', 'as' => 'adminLogin',]);
Route::post('/check-login', [ 'uses' => 'AdminController@checkUserLogin', 'as' => 'checkLogin',]);
Route::get('/logout', [ 'uses' => 'AdminController@logout', 'as' => 'logout',]);

