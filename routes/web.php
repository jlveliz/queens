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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('dologin');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vote/{event?}', 'HomeController@vote')->name('vote');

Route::prefix('/admin')->middleware('admin')->group(function() {
	Route::get('/','AdminController@index');
	Route::resource('/misses', 'MissController');
	Route::resource('/cities', 'CityController');
	Route::resource('/events', 'EventController');
	Route::resource('/users', 'UserController');
});