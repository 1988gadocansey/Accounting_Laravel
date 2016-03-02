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

 
 

// Authentication routes...
Route::get('/', 'LoginController@showLogin'); 

// Authentication routes...
Route::get('/login', 'LoginController@showLogin');
Route::post('/login', 'LoginController@doLogin');
Route::get('/logout', 'LoginController@Logout');
// Registration routes...
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/password/reset', 'Auth\PasswordController@postReset');
 
Route::group(['middleware' => 'CheckLogin'], function()
{
    Route::get('/', "FrameController@show_dashboard");
    Route::get('/navigator', "FrameController@show_navigator");
    Route::get('/home', "FrameController@showIndex");


// create a company but first check if the user is authenticated
Route::get('/setup', array('uses'=>'CompanyController@show')); 
Route::post('/setup', array('uses'=>'CompanyController@store')); 
Route::get('/dashboard', 'GeneralLedgerController@chartaccount');

// accounts
Route::get('/editAccount/{id}/edit', 'AccountController@edit');
Route::post('/editAccount/{id}/edit', 'AccountController@update');
Route::get('/add_account', 'AccountController@showForm');
Route::post('/add_account', 'AccountController@store');
Route::get('/view_accounts', 'AccountController@showAccounts');
Route::delete('/view_accounts','AccountController@destroy');
Route::get('/addPeople', 'PeopleController@showForm');
Route::post('/addPeople', 'PeopleController@store');
Route::get('/view_people', 'PeopleController@index');
Route::delete('/view_people','PeopleController@destroy');
Route::get('/printpeople', "PeopleController@print_all");

// stock

Route::get('/addstock/{id}/edit', 'StockController@showForm');
Route::post('/addstock/{id}/edit', 'StockController@update');
Route::get('/addstock', 'StockController@showForm');
Route::post('/addstock', 'StockController@store');
Route::get('/view_stock', 'StockController@index');
Route::delete('/stock','StockController@destroy');
Route::get('/printstock', "StockController@print_all");

// fixed assets

Route::get('/addassets/{id}/edit', 'AssetController@showForm');
Route::post('/addassets/{id}/edit', 'AssetController@update');
Route::get('/addassets', 'AssetController@showForm');
Route::post('/addassets', 'AssetController@store');
Route::get('/view_assets', 'AssetController@index');
Route::delete('/assets','AssetController@destroy');
Route::get('/printassets', "AssetController@print_all");

// banks
Route::get('/Addbank/{id}/edit', 'BankController@showForm');
Route::post('/Addbank/{id}/edit', 'BankController@update');
Route::get('/view_banks', 'BankController@index');
Route::get('/Addbank', 'BankController@showForm');
Route::post('/Addbank', 'BankController@store');
Route::delete('/Addbank','BankController@destroy');
Route::get('/print_bank','BankController@print_bank');
Route::get('/withdrawals','BankController@showWithdrawals');
Route::post('/withdrawals','BankController@doWithdrawals');
Route::get('/deposit','BankController@showDeposit');
Route::post('/deposit','BankController@doDeposit');
Route::get('/transfers','BankController@showTransfer');
Route::post('/transfers','BankController@doTransfer');
Route::get('/bank_inquiry','BankController@bankEnquiries');


// general ledgerdestroyParent
 
Route::get('/gl_account', 'GeneralLedgerController@index');
Route::get('/print_gl', 'GeneralLedgerController@print_all');
Route::get('/gl_account_groups', "GeneralLedgerController@groups");
Route::get('/editgroup/{id}/edit', "GeneralLedgerController@showgl_edit");
Route::post('/editgroup/{id}/edit', "GeneralLedgerController@updategroup");
Route::post('/gl_account_groups', "GeneralLedgerController@storeparent");
Route::post('/gl_account_groups/{id}/edit', "GeneralLedgerController@updateparent");
Route::delete('/gl_account_groups','GeneralLedgerController@destroyParent');

Route::get('/gl_charts', "GeneralLedgerController@chartaccount");
Route::get('/gl_charts_print', "GeneralLedgerController@print_chart");


// transactions
Route::get('/journal_entry', 'TransactionsController@create');
Route::post('/journal_entry', 'TransactionsController@store');
Route::get('/gl_transactions', 'TransactionsController@index');
Route::get('/gl_transactions_print', 'TransactionsController@print_transactions');
Route::get('/journal_inquiry', 'TransactionsController@journal_inquiry');
Route::get('/journal_inquiry_print', "TransactionsController@print_journal_inquiry");
Route::delete('/journal_inquiry','TransactionsController@destroyJournal');
Route::get('/journal_view/{id}/edit', "TransactionsController@viewJournalTrans");



// asset manager
Route::get('/asset_manager', 'AssetController@manager');

// reports
Route::get('/trial_balance', 'ReportController@trialBalance');
Route::get('/cashbook', 'ReportController@cashBook');
Route::get('/cashbookPrint', "ReportController@cashBookPrint");
Route::get('/income_expenditure', "ReportController@incomeExpenditure");
Route::get('/IEprint', 'ReportController@printIE');
Route::get('/balance_sheet', "ReportController@balanceSheet");
Route::get('/BSprint', 'ReportController@printBS');

// Account Management
Route::get('/system_log', 'UserController@SystemLog');
Route::get('/users', 'UserController@Users');
Route::post('/users/delete', 'UserController@destroy');
Route::post('/users', 'UserController@addUser');
Route::get('/reset', 'UserController@showReset');
Route::post('/reset', 'UserController@doReset');

});

