<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->load(['role']);
})->middleware(Authenticate::using('sanctum'));

Route::get('/settings', [SettingController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot', [AuthController::class, 'forgot']);
Route::get('/verify', [AuthController::class, 'verify']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.update');
Route::apiResource('/events', \App\Http\Controllers\EventController::class);
Route::apiResource('/sales', \App\Http\Controllers\SaleController::class);
Route::apiResource('/products', \App\Http\Controllers\ProductController::class)->only(['index', 'show']);
Route::get('/mail/{item}/{id}/{doc}', [\App\Http\Controllers\MailController::class, 'index']);

Route::middleware(Authenticate::using('sanctum'))->group(function () {
    Route::post('/logout', [AuthController::class, 'login']);
    Route::post('/settings', [SettingController::class, 'update']);
    Route::apiResource('/users', \App\Http\Controllers\UserController::class);
    Route::apiResource('/ticket-types', \App\Http\Controllers\TicketTypeController::class);
    Route::apiResource('/event-types', \App\Http\Controllers\EventTypeController::class);
    Route::apiResource('/show-types', \App\Http\Controllers\ShowTypeController::class);
    Route::apiResource('/product-types', \App\Http\Controllers\ProductTypeController::class);
    Route::apiResource('/payment-methods', \App\Http\Controllers\PaymentMethodController::class);
    Route::apiResource('/shows', \App\Http\Controllers\ShowController::class);
    Route::apiResource('/products', \App\Http\Controllers\ProductController::class)->only(['store', 'update']);
    Route::apiResource('/sales', \App\Http\Controllers\SaleController::class);
    Route::apiResource('/organizations', \App\Http\Controllers\OrganizationController::class);
    Route::apiResource('/organization-types', \App\Http\Controllers\OrganizationTypeController::class);
    Route::apiResource('/membership-types', \App\Http\Controllers\MembershipTypeController::class);
    Route::apiResource('/memberships', \App\Http\Controllers\MembershipController::class);
    Route::post('/sales/{id}/memos', [\App\Http\Controllers\SaleMemoController::class, 'store']);
    Route::apiResource('/reports', \App\Http\Controllers\ReportController::class)->only(['show']);
    Route::apiResource('/roles', \App\Http\Controllers\RoleController::class)->only(['index']);
    Route::post('/stripe/session/create', [\App\Http\Controllers\StripeController::class, 'create']);
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
});
