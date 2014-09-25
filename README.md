vanilla-for-laravel
===================

Laravel 4 package of [Vanilla Forums](https://github.com/vanilla/vanilla).

Installation
------------
Edit your `composer.json` to include:
```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/vanilla/vanilla" }
],
"require": {
    "bishopb/vanilla-for-laravel": "dev-master@dev"
}
```
Run `composer update bishopb/vanilla-for-laravel`.  

Add the package service provider to your `app/config/app.php`:
```php
'providers' => array (
    // ... other providers here
    'BishopB\Vfl\VflServiceProvider',
),
```

Install the migrations: `php artisan vfl:migrate`

Connect Vanilla to Laravel: `php artisan vfl:connect`

Navigate in your app to the `vfl/` route and you will see Vanilla!

Usage
-----
Vanilla does not have the concept of anonymous forums, so you MUST bind some kind of authentication into it.


Configuration
-------------
To override the package behavior, publish the package's configuration files using Artisan:
`php artisan config:publish bishopb/vanilla-for-laravel`

then, edit `app/config/packages/bishopb/vanilla/*php` to suit.
