<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', function () {
    return view('auth.login');//Какую-нибудь приветсвенную страницу
});



//Lots route
Route::patch('/lots', 'LotController@updateStatus')->name('lots.updateStatus');
Route::resource('lots', 'LotController')->middleware(['auth']);

//Offers route
Route::get('/search', 'AuctionController@search')->name('search');
Route::resource('offers', 'UserController')->only(['index', 'show']);




