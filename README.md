# Hotel Nagar Palace

Website and admin panel for **Hotel Nagar Palace** (Residential), Velanagar, Narsingdi.

Built with Laravel 12 (PHP 8.2+, MySQL). The public site uses the design in `desing/`;
all content — pages, header menu, home slider, gallery, rooms, services, packages and
site settings — is managed from the admin panel at `/admin-login`.

## Requirements

- PHP 8.2 or newer (cPanel: ea-php83 works), with `pdo_mysql`, `gd`, `mbstring`, `openssl`, `fileinfo`
- MySQL / MariaDB
- Composer

## Setup

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env          # then set APP_URL, DB_* and APP_KEY
php artisan key:generate      # only for a new installation
```

The database is imported from an existing dump (there is no full migration history),
so run only the migrations added for the hotel version:

```bash
php artisan migrate --force --path=database/migrations/2026_11_05_000001_add_hotel_footer_fields_to_generals_table.php
php artisan migrate --force --path=database/migrations/2026_11_06_000001_widen_mail_password_on_generals_table.php
```

Load the hotel content (settings, pages, menu, slider, gallery, rooms, services, packages).
Safe to run again; it replaces only what it created:

```bash
php artisan db:seed --class=HotelThemeSeeder --force
```

Production `.env`: `APP_ENV=production`, `APP_DEBUG=false`. Then:

```bash
php artisan optimize
```

## Hosting notes

- On cPanel the **project root is the web root**: the root `.htaccess` and `index.php`
  route requests, and assets are linked as `/public/...`. The root `.htaccess` blocks
  direct access to `app/`, `storage/`, `vendor/`, `.git/` etc. — keep those rules.
- Uploaded images go to `public/medies/`, which has its own no-script `.htaccess`.
- Email: Admin → Settings → Mail Setting, then use **Send Test Mail**.

## Local development

`php artisan serve` does not match the cPanel layout (CSS will not load). Use:

```bash
php -S 127.0.0.1:8000 -t . bootstrap/dev-router.php
```
