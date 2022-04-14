<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dummyAPI;
use App\Http\Controllers\profile;
use App\Http\Controllers\CustomerDetails;
use App\Helpers\Shopify;
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
Route::middleware(['auth.shopify'])->group(function(){
 Route::get('/',[CustomerDetails::class, 'customer']);
 Route::get('customerid',[CustomerDetails::class, 'customerid']);
});
// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['auth.shopify'])->name('home');
