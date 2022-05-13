<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


    Route::post('addDiscount','DiscountController@store');
    Route::post('removeDiscount', 'DiscountController@destroy');
    Route::post('checkDiscount','DiscountController@check');
    Route::post('showDiscount','DiscountController@show');
    Route::post('transactionData','DiscountController@transaction');
    Route::post('subtotal','DiscountController@subtotal');
    Route::post('customerUpdate','DiscountController@customerUpdate');
    Route::post('guestlogin','DiscountController@guestLogin');
    //Route::post('ruleid','DiscountController@ruleid');

   // Route::get('show','DiscountController@show');
   // Route::get('dis','DiscountController@show');
   // Route::post('addDiscount','CustomerDetails@addDiscount');

