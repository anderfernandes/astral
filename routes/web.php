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
  Route::resource('products', 'ProductController');
  // Shows resource
  Route::resource('shows', 'ShowController');
  // Members Resource
  Route::resource('members', 'MemberController');
  // Users resource
  Route::resource('users', 'UserController');
  // Organizations resource
  Route::resource('organizations', 'OrganizationController');
  // Events resource
  Route::resource('events', 'EventController');
  // Product Types
  Route::resource('product-types', 'ProductTypeController');
  // Member Types
  Route::resource('member-types', 'MemberTypeController');
  // Grades
  Route::resource('grades', 'GradeController');
  Route::resource('announcements', 'AnnouncementController');
  // Reports
  Route::get('reports/closeout', 'ReportController@closeout')->name('reports.closeout');
  Route::get('reports/transactionDetail', 'ReportController@transactionDetail')->name('reports.transactionDetail');
  Route::get('reports/royalty', 'ReportController@royalty')->name('reports.royalty');
  Route::get('reports/newMembers', 'ReportController@newMembers')->name('reports.newMembers');
  Route::get('reports/overall', 'ReportController@overall')->name('reports.overall');
  Route::get('reports', 'ReportController@index')->name('reports.index');
  // Sales Resource
  //Route::resource('sales', 'SaleController', ['except' => ['create']]);
  Route::resource('sales', 'SaleController');
  Route::post('sales/refund/{sale}', 'SaleController@refund')->name('sales.refund');
  Route::post('sales/refundPayment/{payment}', 'SaleController@refundPayment')->name('sales.refundPayment');
  Route::get('sales/{sale}/confirmation', 'SaleController@confirmation')->name('sales.confirmation');
  Route::get('sales/{sale}/invoice', 'SaleController@invoice')->name('sales.invoice');
  Route::get('sales/{sale}/receipt', 'SaleController@receipt')->name('sales.receipt');
  Route::get('sales/{sale}/cancelation', 'SaleController@cancelation')->name('sales.cancelation');
  Route::get('sales/{sale}/mail', 'SaleController@mail')->name('sales.mail');
  // Setting resource
  Route::resource('settings', 'SettingController');
  // Roles
  Route::resource('roles', 'RoleController');
  // Bulletin
  Route::resource('posts', 'PostController');
  Route::resource('replies', 'ReplyController');
  Route::resource('categories', 'CategoryController');
  // HTTP PUT route for updating general settings
  Route::put('settings', 'SettingController@update');
  // Settings Resources
  Route::resource('ticket-types', 'TicketTypeController');
  Route::resource('event-types', 'EventTypeController');
  // HTTP PUT route for adding managing Organization Types
  Route::post('settings/addOrganizationType', 'SettingController@addOrganizationType')->name('settings.addOrganizationType');
  // HTTP PUT route for adding managing Payment Methods
  Route::post('settings/addPaymentMethod', 'SettingController@addPaymentMethod')->name('settings.addPaymentMethod');
  // HTTP PUT route for adding managing Member Types
  Route::post('settings/addMemberType', 'SettingController@addMemberType')->name('settings.addMemberType');
  // Member Card
  Route::get('members/{member}/card', 'MemberController@card')->name('members.card');
  // Membership Receipt
  Route::get('members/{member}/receipt', 'MemberController@receipt')->name('members.receipt');
  // Membersihp Secondary
  Route::put('members/{member}/addSecondary', 'MemberController@addSecondary')->name('members.addSecondary');
  // Mail Preview
  Route::get('mail/confirmation/{sale}', function(App\Sale $sale) { return new App\Mail\ConfirmationLetter($sale); });
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
    Route::resource('sales', 'SaleController');
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

Route::get('/events', function() { return view('events'); })->name('events');

Route::get('/sales', function() { return view('sales'); })->name('sales'); // PROTECT THIS ROUTE IN A FUTURE RELEASE!
