vanilla-for-laravel
===================

Laravel 4 package of [Vanilla Forums](https://github.com/vanilla/vanilla).

Installation
------------
First, you need to edit your `composer.json` to include at a minimum:
```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/vanilla/vanilla" }
],
"require": {
    "bishopb/vanilla-for-laravel": "dev-master@dev"
}
```
Now run `composer update`.  If you're wondering *why* you have to add this repository, well Vanilla Forums (on which we obviously depend) isn't in Packagist and, since [Composer doesn't resolve dependencies' repositories](https://getcomposer.org/doc/faqs/why-can't-composer-load-repositories-recursively.md), you have to add the Vanilla Forums repository manually.

Now, add the package service provider to your `app/config/app.php`:
```php
'providers' => array (
    // ... other providers here
    'BishopB\Vfl\VflServiceProvider',
),
```


Usage
-----
TODO

Configuration
-------------
To override the package behavior, publish the package's configuration files using Artisan:
`php artisan config:publish bishopb/vanilla-for-laravel`

then, edit `app/config/packages/bishopb/vanilla/*php` to suit.
