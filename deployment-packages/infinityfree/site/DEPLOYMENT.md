# Deployment Guide

This project is a Laravel 13 application and requires PHP 8.3 or newer, Composer, MySQL or MariaDB, and a working SMTP mailbox for email OTP.

## Production Environment

Copy `.env.example` to `.env` on the server, then fill in:

- `APP_KEY`: generate this with `php artisan key:generate --force`
- `APP_URL`: your live `https://...` domain
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
- `ADMIN_PASSWORD`: use a strong password, not the local fallback

There are no SMS or Twilio values. OTP is email-only.

## Uploaded Images

Uploaded files are stored on Laravel's `public` disk:

- Lost item images: `storage/app/public/lost_items`
- Found item images: `storage/app/public/found_items`
- Claim proof images: `storage/app/public/claim_proofs`
- Profile pictures: `storage/app/public/profile_pictures`

The app displays them through `/storage/...`, so the storage link must exist.

For a normal Laravel document root pointing to the `public` folder, run:

```bash
php artisan storage:link
```

For a shared-hosting setup where `public_html` is separate from the Laravel project folder, create the storage link inside `public_html`:

```bash
ln -s /home/CPANEL_USER/lost-found-system/storage/app/public /home/CPANEL_USER/public_html/storage
```

Replace `CPANEL_USER` and `lost-found-system` with the real account and folder names.

## What Goes Inside public_html

If your host forces the site to use `public_html`, put only the contents of the Laravel `public` folder inside `public_html`:

- `.htaccess`
- `index.php`
- `robots.txt`
- `favicon.ico`
- `css/`
- `js/`
- `images/`
- `storage` symlink pointing to `../lost-found-system/storage/app/public`
- `build/` only if you later generate Vite assets

Do not put these inside `public_html`:

- `.env`
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/` application folder
- `tests/`
- `vendor/`

After copying `public/index.php` into `public_html/index.php`, update these paths:

```php
if (file_exists($maintenance = __DIR__.'/../lost-found-system/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../lost-found-system/vendor/autoload.php';

$app = require_once __DIR__.'/../lost-found-system/bootstrap/app.php';
```

Use your actual Laravel project folder name if it is not `lost-found-system`.

## cPanel or Shared Hosting

Preferred layout:

- Full Laravel project: `/home/CPANEL_USER/lost-found-system`
- Web root: `/home/CPANEL_USER/public_html`
- Public files only: copied from `/home/CPANEL_USER/lost-found-system/public`

Run these commands from the Laravel project folder:

```bash
cd /home/CPANEL_USER/lost-found-system
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate --force
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
ln -s /home/CPANEL_USER/lost-found-system/storage/app/public /home/CPANEL_USER/public_html/storage
```

If cPanel does not provide SSH or Composer, run `composer install --no-dev --optimize-autoloader` locally, then upload the generated `vendor/` folder with the project files.

## VPS Deployment

Install the server packages, then deploy the app under `/var/www/lost-found-system` and point the web server to `/var/www/lost-found-system/public`.

Example Ubuntu commands:

```bash
sudo apt update
sudo apt install -y nginx mysql-server php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd unzip git
sudo mkdir -p /var/www/lost-found-system
sudo chown -R $USER:www-data /var/www/lost-found-system
cd /var/www/lost-found-system
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Example Nginx site:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/lost-found-system/public;
    index index.php index.html;
    client_max_body_size 8M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

After enabling the site and SSL, run:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

## Final Checks

Run these after deployment:

```bash
php artisan route:list --except-vendor
php artisan migrate:status
php artisan config:clear
php artisan config:cache
```

Then test:

- Student registration email OTP
- Student login
- Forgot password email OTP
- Profile email change OTP
- Profile phone change OTP sent to current email
- Lost item upload
- Found item upload
- Claim proof upload
- Profile picture upload
- Admin login
