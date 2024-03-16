<?php

use App\Mail\Sales\Receipt;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify/{id}/{hash}', function () {
    return response()->redirectTo('/');
})->name('verification.verify');

Route::get('/reset-password/{token}', function (string $token) {
    return view('welcome', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::get('/mail/sales/{id}/{doc}', function (string $id, string $doc) {
    $sale = (new \App\Models\Sale())->find($id);

    if ($sale == null) {
        return response()->noContent(404);
    }

    Mail::to("handerson171@gmail.com")->send(new Receipt($sale));

    return (new App\Mail\Sales\Receipt($sale))->render();
});
