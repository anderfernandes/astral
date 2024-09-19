<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $organization = DB::table('settings')->find(1)->organization;

            return (new MailMessage)
                ->subject("Verify your $organization account")
                ->line('Please click the button below to verify your account.')
                ->action('Verify Account', env('APP_URL').'/verify?token='.sha1($notifiable->getEmailForVerification()));
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $url) {
            $organization = DB::table('settings')->find(1)->organization;

            return (new MailMessage)
                ->subject("Reset your $organization password")
                ->line('You are receiving this email because we received a password reset request for your account.')
                ->action('Reset Password', env('APP_URL').'/reset?token='.$url)
                ->line('This password reset link will expire in 1 hour.')
                ->line('If you did not request a password reset, no further action is required');
        });
    }
}
