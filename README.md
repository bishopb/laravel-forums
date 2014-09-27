# Laravel Forms

A forums package for Laravel 4, built upon the [Vanilla Forums](https://github.com/vanilla/vanilla) engine.

You might want this package if:
  1. You need a first-class forums solution integrated into your Laravel app, and
  2. You are too busy or too lazy to write one yourself, and optionally
  3. You want to programatically create forum users, discussion boards, wall notices, etc.

Sound like what you need then?  Then this is your package!  We've packaged the excellent Vanilla Forums in a way that Laravel developers will love.
  * Compose it into your app just like any other package.
  * Access the Vanilla database tables using Eloquent models.
  * Modify the look and feel using templates.
  * Configure the forums using the typical configuration files.

## Requirements
You will need:
 1. [Laravel 4](http://laravel.com).
 2. [MySQL 5](http://mysql.com).

## Installation
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

Navigate to the `/vfl` route.  You should see an error, because Vanilla doesn't yet know about your users.  The last step is to decide and implement how your users map to Vanilla.  See the next section, Usage.

## Mapping application users to forum users
Your application has Users.  So does Vanilla.  The two user sets are compatible, but probably not a one-to-one mapping.  Consequently, you'll need to explicitly define how the two map.

Vanilla for Laravel ships with three mappers:
 1. Your application's user and Vanilla's map one-to-one by their ID primary key
 2. You synchronize the Vanilla user information every time it's requested
 3. You custom define the relationship

### One-to-one mapping by primary key
This is the default.  When your users navigate into the Vanilla route, the Vanilla user with the same ID as your app user is logged into Vanilla.  For this to work, you will have to create, modify, and delete Vanilla users when you create, modify, or delete your own users.  Code like this will get you started:
```php
use \BishopB\Vfl\User;
use \BishopB\Vfl\UserRepository;
use \BishopB\Vfl\RoleRepository;

// create a moderator member
$user = UserRepository::createWithRoles(
    [
        'Name' => 'Jane Q. Doe',
        'Password' => User::crypt_password(str_random(64), 'vanilla'),
        'HashMethod' => 'vanilla',
    ],
    [ RoleRepository::member(), RoleRepository::moderator() ]
);

```
### Auto-synchronization
This is the easiest to get going, but is not terribly efficient. Every time your users navigate into the Vanilla route, the mapper either creates a new Vanilla user to match the application user, or updates the Vanilla user to reflect the current data in the application user. You only need to define exactly what happens, like so:
```php
use \Illuminate\Auth\UserInterface as AppUser;
use \BishopB\Vfl\User as VanillaUser;

\App::bind('BishopB\Vfl\UserMapperInterface', function () {
    $mapper = new \BishopB\Vfl\UserMapperSynchronicity();
    $mapper->create_guest_account = null; // you don't want guest access
                                          // or assign a function to create
                                          // a guest user
    $mapper->create_account_for = function ($vanillaID, AppUser $user) {
        return UserRepository::createWithRoles(
            [
                'UserID' => $vanillaID,
                'Name' => $user->lastCommaFirstName,
                'Password' => str_random(64),
                'HashMethod' => 'random',
            ],
            [ RoleRepository::member() ]
        );
    };
    $mapper->update_account_for = function (AppUser $user, VanillaUser $vanillaUser) {
        $vanillaUser->Name = $user->lastCommaFirstName;
        $vanillaUser->save();
    };
    return $mapper;
});
```

### Custom mapping
Just like it says: custom.  You can totally do anything you want.
```php
\App::bind('BishopB\Vfl\UserMapperInterface', function () {
    $mapper = new \BishopB\Vfl\UserMapperByClosure();
    $mapper->setClosure(function (\Illuminate\Auth\UserInterface $user = null) {
        // do whatever you want, it should return a \BishopB\Vfl\User
    });
    return $mapper;
});
```

## Themes
You have full control over the look and feel of your Vanilla install.

Follow the instructions in [`views/themes/default/README.md`](views/themes/default/README.md).

## Events
Vanilla emits events during its operation, and you can use these events to modify how Vanilla operates.  To begin, read up on [Vanilla Plugin development](http://vanillaforums.org/docs/pluginquickstart).  Then, capture the events:
```php
\Event::listen('vfl.event', function ($data) {
    // use $data according to the plugin guidelines
});
```

## Troubleshooting
Things go wrong.  There's a least a way to peek under the hood and see what the Vanilla engine is doing.  Here you go:

  * Publish the package configuration files: `php artisan config:publish bishopb/vanilla-for-laravel`
  * Edit `app/config/packages/bishopb/vanilla-for-laravel/package.php`
  * Set all these flags to `true`: `trace`, `trace-include-events`, `trace-include-queries`.
  * Check your `app/storage/logs/laravel.log` for details.

## Frequently Asked Questions
1. **What does this package provide?**  Simply, forum software for Laravel.  Using the awesome Vanilla Forums engine, your Laravel application can now quickly and easily include fully-function discussion boards.
2. **Is it free?** Yes, of course.
3. **Can it do _______**?  If the community edition of Vanilla Forums can do it, this package can do it, but might not currently do it.
4. **What "gaps" exist between this package and Vanilla Forums?**  This may not be a complete list: plugins.
