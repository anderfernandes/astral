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
  Route::get('calendar/', 'AdminController@calendar')->name('calendar.index');
  // Shows resource
  Route::get('shows/search', 'ShowController@search')->name('shows.search');
  Route::resource('shows', 'ShowController');
  // Members Resource
  Route::resource('members', 'MemberController');
  // Users resource
  Route::resource('users', 'UserController');
  // Organizations resource
  Route::resource('organizations', 'OrganizationController');
  // Events resource
  Route::resource('events', 'EventController');
  // Reports
  Route::get('reports/{type}/{user}/{date}', 'ReportController@reports')->name('reports');
  Route::get('reports/royalty', 'ReportController@royalty')->name('reports.royalty');
  Route::get('reports', 'ReportController@index')->name('reports.index');
  // Sales Resource
  Route::resource('sales', 'SaleController', ['except' => ['create']]);
  Route::post('sales/refund/{sale}', 'SaleController@refund')->name('sales.refund');
  Route::post('sales/refundPayment/{payment}', 'SaleController@refundPayment')->name('sales.refundPayment');
  Route::get('sales/create/{eventType}', 'SaleController@create')->name('sales.create');
  Route::get('sales/{sale}/confirmation', 'SaleController@confirmation')->name('sales.confirmation');
  Route::get('sales/{sale}/invoice', 'SaleController@invoice')->name('sales.invoice');
  Route::get('sales/{sale}/receipt', 'SaleController@receipt')->name('sales.receipt');
  Route::get('sales/{sale}/cancelation', 'SaleController@cancelation')->name('sales.cancelation');
  // Setting resource
  Route::resource('settings', 'SettingController');
  // Roles
  Route::resource('roles', 'RoleController');
  Route::resource('ticket-types', 'TicketTypeController');
  // HTTP PUT route for updating general settings
  Route::put('settings', 'SettingController@update');
  // HTTP PUT route for adding managing Organization Types
  Route::post('settings/addOrganizationType', 'SettingController@addOrganizationType')->name('settings.addOrganizationType');
  // HTTP PUT route for adding managing Ticket Types
  Route::post('settings/addTicketType', 'SettingController@addTicketType')->name('settings.addTicketType');
  Route::get('settings/{ticketType}/edit', 'SettingController@editTicketType')->name('settings.editTicketType');
  // HTTP PUT route for adding managing Payment Methods
  Route::post('settings/addPaymentMethod', 'SettingController@addPaymentMethod')->name('settings.addPaymentMethod');
  // HTTP PUT route for adding managing Event Types
  Route::post('settings/addEventType', 'SettingController@addEventType')->name('settings.addEventType');
  // HTTP PUT route for adding managing Member Types
  Route::post('settings/addMemberType', 'SettingController@addMemberType')->name('settings.addMemberType');
  // Member Card
  Route::get('members/{member}/card', 'MemberController@card')->name('members.card');
  // Membership Receipt
  Route::get('members/{member}/receipt', 'MemberController@receipt')->name('members.receipt');
  // Membersihp Secondary
  Route::put('members/{member}/addSecondary', 'MemberController@addSecondary')->name('members.addSecondary');
});
// Cashier Routes
Route::group(['prefix' => 'cashier', 'as' => 'cashier.', 'namespace' => 'Cashier', 'middleware' => 'auth'],
  function() {
    // Index
    Route::get('/', 'CashierController@index')->name('index');
    // Store Cashier Sale
    Route::post('/', 'CashierController@store')->name('store');
    // Reports
    Route::get('reports/{type}', 'ReportController@reports')->name('reports');
    // Find Sale
    Route::post('query', 'SaleController@query')->name('query');
    // Sales
    Route::resource('sales', 'SaleController', ['except' => ['create']]);
    Route::get('sales/create/{eventType}', 'SaleController@create')->name('sales.create');
    Route::get('sales/{sale}/confirmation', 'SaleController@confirmation')->name('sales.confirmation');
    Route::get('sales/{sale}/invoice', 'SaleController@invoice')->name('sales.invoice');
    Route::get('sales/{sale}/receipt', 'SaleController@receipt')->name('sales.receipt');
    Route::get('sales/{sale}/cancelation', 'SaleController@cancelation')->name('sales.cancelation');
    // Members
    Route::resource('members', 'MemberController');
    // Users (edit member only)
    Route::resource('users', 'UserController');
    // Member Card
    Route::get('members/{member}/card', 'MemberController@card')->name('members.card');
    // Membership Receipt
    Route::get('members/{member}/receipt', 'MemberController@receipt')->name('members.receipt');
    // Membersihp Secondary
    Route::put('members/{member}/addSecondary', 'MemberController@addSecondary')->name('members.addSecondary');
  });

Auth::routes();

Route::put('account/selfupdate', 'Admin\UserController@selfupdate')->middleware('auth')->name('selfupdate');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/account', 'HomeController@account')->name('account')->middleware('auth');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/upcoming', function() { return view('upcoming'); })->name('upcoming');

Route::get('/calendar', function() { return view('calendar'); })->name('upcoming');
