<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
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
        // Brute-force protection for login / register / password reset.
        // Only form submissions count; simply viewing the pages is never limited.
        RateLimiter::for('auth', function (Request $request) {
            if (! $request->isMethod('post')) {
                return Limit::none();
            }

            return [
                Limit::perMinute(10)->by('auth-ip:'.$request->ip()),
                Limit::perMinute(5)->by('auth-id:'.strtolower((string) $request->input('email')).'|'.$request->ip()),
            ];
        });

        // Public forms that send mail (contact, enquiry, subscribe, comments).
        RateLimiter::for('forms', function (Request $request) {
            return $request->isMethod('post')
                ? Limit::perMinute(6)->by('forms:'.$request->ip())
                : Limit::none();
        });

        try {
            $general = general();
        } catch (\Throwable $e) {
            // Database not reachable yet (fresh install, migrations, etc.).
            return;
        }

        if (! $general) {
            return;
        }

        // Only override config values that are actually set, so an empty
        // settings row never breaks the mailer / socialite configuration.
        $map = [
            'services.facebook.client_id' => $general->fb_app_id,
            'services.facebook.client_secret' => $general->fb_app_secret,
            'services.facebook.redirect' => $general->fb_app_redirect_url,

            'services.google.client_id' => $general->google_client_id,
            'services.google.client_secret' => $general->google_client_secret,
            'services.google.redirect' => $general->google_client_redirect_url,

            'mail.mailers.smtp.host' => $general->mail_host,
            'mail.mailers.smtp.port' => $general->mail_port,
            'mail.mailers.smtp.username' => $general->mail_username,
            'mail.mailers.smtp.password' => self::mailPassword($general->mail_password),
            'mail.from.address' => $general->mail_from_address,
            'mail.from.name' => $general->mail_from_name ?: $general->title,
        ];

        foreach ($map as $key => $value) {
            if ($value !== null && $value !== '') {
                Config::set($key, $value);
            }
        }

        // Settings > Mail: "sendmail" uses the server's mail program (cPanel);
        // everything else goes through SMTP. ("mail"/"mailgun" from the old form
        // are not transports in Laravel 12, so they fall back to SMTP.)
        Config::set('mail.default', $general->mail_driver === 'sendmail' ? 'sendmail' : 'smtp');

        // Laravel 12 picks SSL vs STARTTLS from the "scheme": port 465 or "SSL" = smtps.
        $port = (int) ($general->mail_port ?: 0);
        Config::set('mail.mailers.smtp.scheme', ($port === 465 || $general->mail_encryption === 'ssl') ? 'smtps' : 'smtp');
        // Don't let a dead mail server hang checkout / contact pages for a minute.
        Config::set('mail.mailers.smtp.timeout', 15);
    }

    /**
     * The mail password is stored encrypted (APP_KEY); older rows may still be plain text.
     */
    public static function mailPassword($stored)
    {
        if ($stored === null || $stored === '') {
            return $stored;
        }
        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($stored);
        } catch (\Throwable $e) {
            return $stored;
        }
    }
}
