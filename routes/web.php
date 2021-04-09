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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/seller', 'SellerController@index')->middleware('auth');
Route::get('/seller/create', 'SellerController@create')->middleware('auth');
Route::post('/seller/store', 'SellerController@store')->middleware('auth');

Route::get('/seller/commodity/{id}', 'SellerSkuController@index')->middleware('auth');
Route::get('/seller/commodity/{id}/create', 'SellerSkuController@create')->middleware('auth');
Route::post('/seller/commodity/{id}/store', 'SellerSkuController@store')->middleware('auth');
Route::delete('/seller/commodity/{id}/destroy', 'SellerSkuController@destroy')->middleware('auth');
