<?php

use Illuminate\Http\Request;

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

Route::get('users/{user}', function (App\User $user) {
    dd($user);
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('insert', 'CartController@insert');
    Route::post('buycart', 'CartController@buycart');
    Route::post('greed', 'CartController@greed');
    Route::post('member_address', 'Member_AddressController@member_address');
    Route::post('address', 'Member_AddressController@address');
    Route::post('show', 'Member_AddressController@show');
    Route::post('cart_two', 'Cart_TwoController@cart_two');
    Route::post('cart_two1', 'Cart_TwoController@cart_two1');
    Route::post('add', 'Cart_TwoController@add');
     Route::post('add1', 'Cart_TwoController@add1');



});

   Route::post('goods','HomeController@goods');
   Route::get('tree','HomeController@tree');
   Route::get('tree1','HomeController@tree1');
   Route::post('product','HomeController@product');



