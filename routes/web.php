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

Route::get('/', function (){
    return view('auth.login');//Какую-нибудь приветсвенную страницу
});
Route::group([
    'middleware' => 'auth',
    'prefix' => 'lots',
], function(){
    Route::get('/', 'LotController@index')->name('lots.index');
    Route::post('/', 'LotController@store')->name('lots.store');
    Route::get('/create', 'LotController@create')->name('lots.create');
    Route::patch('/{lot}', 'LotController@update')->name('lots.update') ;
    Route::get('/{lot}', 'LotController@show')->name('lots.show');
    Route::get('/{lot}/edit', 'LotController@edit')->name('lots.edit');
    Route::delete('/{lot}', 'LotController@destroy')->name('lots.destroy');

});

Route::group([
    'prefix' => 'offers',
], function(){
    Route::get('/', 'AuctionController@index')->name('offers.index');
    Route::get('/{offer}', 'AuctionController@show')->name('offers.show');


});



