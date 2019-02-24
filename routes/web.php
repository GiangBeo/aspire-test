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

Route::post('/create-user', 'UserController@createUser');

Route::post('/approve-loan', 'LoanController@approveLoan');
Route::post('/repayment-loan', 'LoanController@addPayment');
Route::post('/transfer-loan', 'LoanController@transferLoan');
Route::post('/reject-loan', 'LoanController@transferLoan');