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

// Admin Routes
Route::group(
  ['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'],
  function() {
  // Index
  Route::get('/', 'AdminController@index')->name('index');
  // Shows resource
  Route::resource('shows', 'ShowController');
  // Users resource
  Route::resource('users', 'UserController');
  // Events resource
  Route::resource('events', 'EventController');
  // Sales Resource
  Route::resource('sales', 'SaleController');
  // Setting resource
  Route::resource('settings', 'SettingController');
  Route::put('settings', 'SettingController@update');
});

Auth::routes();

// Cashier Route
Route::get('cashier', 'CashierController@index')->name('cashier.index')->middleware('auth');

Route::post('cashier', 'CashierController@store')->name('cashier.store')->middleware('auth');

Route::post('cashier/query', 'CashierController@query')->name('cashier.query')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/account', 'HomeController@account')->name('account')->middleware('auth');
