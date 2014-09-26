vanilla-for-laravel
===================

Laravel 4 package of [Vanilla Forums](https://github.com/vanilla/vanilla).

You might want this package if:
  1. You need a first-class forums solution integrated into your Laravel app, and
  2. You are too busy or too lazy to write one yourself, and optionally
  3. You want to programatically create forum users, discussion boards, wall notices, etc.

Sound like what you need then?  Then this is your package!  We've packaged the excellent Vanilla Forums in a way that Laravel developers will love.
  * Compose it into your app just like any other package.
  * Access the Vanilla data using Eloquent models.
  * Modify the look and feel using templates.
  * Configure the forums using the typical configuration files.

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
Vanilla Forums has [no concept of anonymous posting](https://github.com/vanilla/vanilla/issues/465), which means you must have at least one Vanilla user model and you must authenticate to Vanilla appropriately.  Bottom line: you cannot use this package out of the box.  Find your use case and implement accordingly:

| You Want | You Must |
| 1. Guest users to post to your forum as "Anonymous". | Create an anonymous Vanilla user and authenticate that user when your app boots.  Posts will be made as that user. |
| 2. Autheticated users to post as themselves. | Create one Vanilla user for every user in your app and authenticate that user to Vanilla upon login.  When the user is deleted, archive the user in Vanilla. |

++ Creating a user with a particular roles
```php
use \BishopB\Vfl\User;
use \BishopB\Vfl\RoleRepository;

$user = User::createWithRoles(
    [ 'Name' => 'Whatever', 'Email' => 'x@example.com', ... ],
    [ RoleRepository::member(), RoleRepository::moderator() ]
);
```

Configuration
-------------
To override the package behavior, publish the package's configuration files using Artisan:
`php artisan config:publish bishopb/vanilla-for-laravel`

then, edit `app/config/packages/bishopb/vanilla/*php` to suit.
