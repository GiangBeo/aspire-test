<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/create-loan', 'LoanController@createLoan');
Route::middleware('auth:api')->post('/approve-loan', 'LoanController@approveLoan');
Route::middleware('auth:api')->post('/repayment-loan', 'LoanController@addPayment');
Route::middleware('auth:api')->post('/transfer-loan', 'LoanController@transferLoan');

