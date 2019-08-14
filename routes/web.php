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
    return view('welcome');
});

Route::get('login/login','LoginController@login');
Route::get('login/loginaction','LoginController@loginaction');
Route::match(['get', 'post'], 'foo', function () {
    return 'This is a request from get or post';
});
Route::any('show/show','ShowController@show');

Route::any('show/show2','ShowController@show2');


Route::any('home/bb','HomeController@bb');
Route::any('home/test','HomeController@test');


Route::group(['middleware'=> \App\Http\Middleware\CheckToken::class,],function(){
	
	Route::get('show/index','ShowController@index');
	Route::get('show/addaction','ShowController@addaction');
	Route::get('login/loginout','LoginController@loginout');
});

// Route::prefix('v1.0')->group(function () {
// 	Route::get('home/showcategory','HomeController@showCategory');
// });




