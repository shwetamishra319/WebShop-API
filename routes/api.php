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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('orders', 'App\Http\Controllers\OrderController@index');
Route::post('orders', 'App\Http\Controllers\OrderController@store');
Route::get('orders/{id}', 'App\Http\Controllers\OrderController@show');
Route::put('orders/{id}', 'App\Http\Controllers\OrderController@update');
Route::delete('orders/{id}', 'App\Http\Controllers\OrderController@destroy');
Route::post('/api/orders/{id}/add' , 'App\Http\Controllers\OrderController@addNewProductInOrder');
Route::post('/api/orders/{id}/pay' , 'App\Http\Controllers\OrderController@makePayment');
