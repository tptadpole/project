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
Route::delete('/seller/{id}/destroy', 'SellerController@destroy')->middleware('auth');
Route::patch('/seller/{id}/update', 'SellerController@update')->middleware('auth');
Route::get('/seller/{id}/edit', 'SellerController@edit')->middleware('auth');

Route::get('/seller/commodity/{id}', 'SellerSkuController@index')->middleware('auth');
Route::get('/seller/commodity/{id}/create', 'SellerSkuController@create')->middleware('auth');
Route::post('/seller/commodity/{id}/store', 'SellerSkuController@store')->middleware('auth');
Route::delete('/seller/commodity/{id}/destroy', 'SellerSkuController@destroy')->middleware('auth');
Route::patch('/seller/commodity/{id}/update', 'SellerSkuController@update')->middleware('auth');
Route::get('/seller/commodity/{id}/edit', 'SellerSkuController@edit')->middleware('auth');

Route::get('/customer', 'CustomerController@index');
Route::get('/customer/{id}', 'CustomerController@show');

Route::get('/cart', 'CartController@index')->middleware('auth');
Route::post('/cart/{id}/store', 'CartController@store')->middleware('auth');
Route::get('/cart/{id}/edit', 'CartController@edit')->middleware('auth');
Route::patch('/cart/{id}/update', 'CartController@update')->middleware('auth');
Route::delete('/cart/{id}/destroy', 'CartController@destroy')->middleware('auth');

Route::get('/order', 'OrderController@index')->middleware('auth');
Route::get('/order/create', 'OrderController@create')->middleware('auth');
Route::post('/order/store', 'OrderController@store')->middleware('auth');
Route::delete('/order/{id}/destroy', 'OrderController@destroy')->middleware('auth');

Route::get('/orderItem', 'OrderItemController@index')->middleware('auth');
Route::get('/orderItem/{id}', 'OrderItemController@show')->middleware('auth');
Route::get('/orderItem/{id}/store', 'OrderItemController@store')->middleware('auth');
Route::patch('/orderItem/{id}/update', 'OrderItemController@update')->middleware('auth');




Route::get('/admin', 'AdminController@index')->middleware('can:admin');

Route::get('/admin/users', 'AdminUserController@index')->middleware('can:admin');
Route::get('/admin/users/create', 'AdminUserController@create')->middleware('can:admin');
Route::post('/admin/users/store', 'AdminUserController@store')->middleware('can:admin');
Route::get('/admin/users/{id}/edit', 'AdminUserController@edit')->middleware('can:admin');
Route::patch('/admin/users/{id}/update', 'AdminUserController@update')->middleware('can:admin');
Route::delete('/admin/users/{id}/destroy', 'AdminUserController@destroy')->middleware('can:admin');

Route::get('/admin/spu', 'AdminSpuController@index')->middleware('can:admin');
Route::get('/admin/spu/{id}/edit', 'AdminSpuController@edit')->middleware('can:admin');
Route::patch('/admin/spu/{id}/update', 'AdminSpuController@update')->middleware('can:admin');
Route::delete('/admin/spu/{id}/destroy', 'AdminSpuController@destroy')->middleware('can:admin');

Route::get('/admin/sku', 'AdminSkuController@index')->middleware('can:admin');
Route::get('/admin/sku/{id}/edit', 'AdminSkuController@edit')->middleware('can:admin');
Route::patch('/admin/sku/{id}/update', 'AdminSkuController@update')->middleware('can:admin');
Route::delete('/admin/sku/{id}/destroy', 'AdminSkuController@destroy')->middleware('can:admin');

Route::get('/admin/cart', 'AdminCartController@index')->middleware('can:admin');
Route::delete('/admin/cart/{id}/destroy', 'AdminCartController@destroy')->middleware('can:admin');

Route::get('/admin/order', 'AdminOrderController@index')->middleware('can:admin');
Route::delete('/admin/order/{id}/destroy', 'AdminOrderController@destroy')->middleware('can:admin');

Route::get('/admin/orderItem/index', 'AdminOrderItemController@index')->middleware('can:admin');
Route::get('/admin/orderItem/show', 'AdminOrderItemController@show')->middleware('can:admin');
Route::patch('/admin/orderItem/{id}/update', 'AdminOrderItemController@update')->middleware('can:admin');
Route::delete('/admin/orderItem/{id}/destroy', 'AdminOrderItemController@destroy')->middleware('can:admin');
