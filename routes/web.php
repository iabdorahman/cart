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

Route::get('/', function () {
    return redirect('store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/store', 'HomeController@store')->name('store');
Route::get('store/products', 'ProductController@index')->name('product.index');
Route::get('store/addToCart/{product}', 'ProductController@addToCart')->name('cart.add');
Route::get('store/shopping-cart', 'ProductController@showCart')->name('cart.show');
Route::get('store/checkout/{amount}', 'ProductController@checkout')->name('cart.checkout');
Route::post('/charge', 'ProductController@charge')->name('cart.charge');
Route::get('/orders', 'OrderController@index')->name('order.index');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.remove');
Route::put('/product/{product}', 'ProductController@updateQty')->name('product.updateQty');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
