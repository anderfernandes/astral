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
    return view('auth.login');
})->middleware('guest');

// Admin Routes
Route::group(
  ['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'],
  function() {
  // Index
  Route::get('/', 'AdminController@index')->name('index');
  // Calendar
  Route::get('calendar', function(){ return view('admin.calendar.index'); })->name('calendar.index');
  // Shows resource
  Route::resource('shows', 'ShowController');
  // Users resource
  Route::resource('users', 'UserController');
  // Organizations resource
  Route::resource('organizations', 'OrganizationController');
  // Events resource
  Route::resource('events', 'EventController');
  // Sales Resource
  Route::resource('sales', 'SaleController');
  Route::post('sales/refund/{sale}', 'SaleController@refund')->name('sales.refund');
  // Setting resource
  Route::resource('settings', 'SettingController');
  // HTTP PUT route for updating general settings
  Route::put('settings', 'SettingController@update');
  // HTTP PUT route for adding managing Organization Types
  Route::post('settings/addOrganizationType', 'SettingController@addOrganizationType')->name('settings.addOrganizationType');
  // HTTP PUT route for adding managing Ticket Types
  Route::post('settings/addTicketType', 'SettingController@addTicketType')->name('settings.addTicketType');
  // HTTP PUT route for adding managing Payment Methods
  Route::post('settings/addPaymentMethod', 'SettingController@addPaymentMethod')->name('settings.addPaymentMethod');
  // HTTP PUT route for adding managing Event Types
  Route::post('settings/addEventType', 'SettingController@addEventType')->name('settings.addEventType');
});
// Cashier Routes
Route::group(['prefix' => 'cashier', 'as' => 'cashier', 'middleware' => 'auth'],
  function() {
    // Index
    Route::get('/', 'CashierController@index')->name('.index');
    // Store Sale
    Route::post('/', 'CashierController@store')->name('.store');
    // Reports
    Route::get('reports/{type}', 'CashierController@reports')->name('.reports');
    // Find Sale
    Route::post('query', 'CashierController@query')->name('.query');
    // Sale Details
    Route::get('sale/{sale}', 'CashierController@sale')->name('.sale');
  });

Auth::routes();

Route::put('account/selfupdate', 'Admin\UserController@selfupdate')->middleware('auth')->name('selfupdate');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/account', 'HomeController@account')->name('account')->middleware('auth');
