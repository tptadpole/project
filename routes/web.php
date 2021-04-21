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

Route::middleware('auth')->prefix('seller')->group(function () {
    Route::get('/', 'SellerController@index');
    Route::get('/create', 'SellerController@create');
    Route::post('/store', 'SellerController@store');
    Route::delete('/{id}/destroy', 'SellerController@destroy');
    Route::patch('/{id}/update', 'SellerController@update');
    Route::get('/{id}/edit', 'SellerController@edit');
});

Route::middleware('auth')->prefix('seller/commodity/{id}')->group(function () {
    Route::get('/', 'SellerSkuController@index');
    Route::get('/create', 'SellerSkuController@create');
    Route::post('/store', 'SellerSkuController@store');
    Route::delete('/destroy', 'SellerSkuController@destroy');
    Route::patch('/update', 'SellerSkuController@update');
    Route::get('/edit', 'SellerSkuController@edit');
});

Route::get('/customer', 'CustomerController@index');
Route::get('/customer/{id}', 'CustomerController@show');

Route::middleware('auth')->prefix('cart')->group(function () {
    Route::get('/', 'CartController@index');
    Route::post('/{id}/store', 'CartController@store');
    Route::get('/{id}/edit', 'CartController@edit');
    Route::patch('/{id}/update', 'CartController@update');
    Route::delete('/{id}/destroy', 'CartController@destroy');
});

Route::middleware('auth')->prefix('order')->group(function () {
    Route::get('/', 'OrderController@index');
    Route::get('/create', 'OrderController@create');
    Route::post('/store', 'OrderController@store');
    Route::delete('/{id}/destroy', 'OrderController@destroy');
});

Route::middleware('auth')->prefix('orderItem')->group(function () {
    Route::get('/', 'OrderItemController@index');
    Route::get('/{id}', 'OrderItemController@show');
    Route::get('/{id}/store', 'OrderItemController@store');
    Route::patch('/{id}/update', 'OrderItemController@update');
});

Route::get('/admin', 'AdminController@index')->middleware('can:admin');

Route::middleware('can:admin')->prefix('admin/users')->group(function () {
    Route::get('/', 'AdminUserController@index');
    Route::get('/create', 'AdminUserController@create');
    Route::post('/store', 'AdminUserController@store');
    Route::get('/{id}/edit', 'AdminUserController@edit');
    Route::patch('/{id}/update', 'AdminUserController@update');
    Route::delete('/{id}/destroy', 'AdminUserController@destroy');
});

Route::middleware('can:admin')->prefix('admin/spu')->group(function () {
    Route::get('/', 'AdminSpuController@index');
    Route::get('/{id}/edit', 'AdminSpuController@edit');
    Route::patch('/{id}/update', 'AdminSpuController@update');
    Route::delete('/{id}/destroy', 'AdminSpuController@destroy');
});

Route::middleware('can:admin')->prefix('admin/sku')->group(function () {
    Route::get('/', 'AdminSkuController@index');
    Route::get('/{id}/edit', 'AdminSkuController@edit');
    Route::patch('/{id}/update', 'AdminSkuController@update');
    Route::delete('/{id}/destroy', 'AdminSkuController@destroy');
});

Route::middleware('can:admin')->prefix('admin/cart')->group(function () {
    Route::get('/', 'AdminCartController@index');
    Route::delete('/{id}/destroy', 'AdminCartController@destroy');
});

Route::middleware('can:admin')->prefix('admin/order')->group(function () {
    Route::get('/', 'AdminOrderController@index');
    Route::delete('/{id}/destroy', 'AdminOrderController@destroy');
});

Route::middleware('can:admin')->prefix('admin/orderItem')->group(function () {
    Route::get('/index', 'AdminOrderItemController@index');
    Route::get('/show', 'AdminOrderItemController@show');
    Route::get('/{id}/display', 'AdminOrderItemController@display');
    Route::patch('/{id}/update', 'AdminOrderItemController@update');
    Route::delete('/{id}/destroy', 'AdminOrderItemController@destroy');
});
