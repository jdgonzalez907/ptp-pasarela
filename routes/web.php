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
    return redirect('checkout');
});

Route::get('checkout', 'CheckoutController@index');
Route::get('checkout/create', 'CheckoutController@create');
Route::post('checkout', 'CheckoutController@store');
Route::get('checkout/callback/{id}', 'CheckoutController@callback');
Route::post('checkout/notification/{id}', 'CheckoutController@notification');
