# Laravel Forums

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

**WARNING**: This package is pre-alpha and under active development. [Please report issues](https://github.com/bishopb/laravel-forums/issues) and look-out for BC breakage.

## Requirements
You will need:
 1. [Laravel 4.2](http://laravel.com)
 2. [MySQL 5](http://mysql.com)

## Installation
Edit your `composer.json` to include:
```json
"require": {
    "bishopb/laravel-forums": "~0.1"
},
```
Run `composer update bishopb/laravel-forums --no-dev`.  

Add the package service provider to your `app/config/app.php`:
```php
'providers' => array (
    // ... other providers here
    'BishopB\Forum\ForumServiceProvider',
),
```
Install the migrations: `php artisan forum:migrate`  

Connect Vanilla and Laravel: `php artisan forum:connect`  

Navigate to the `/forum` route.  You should see a forum with no posts, logged in as "Anonymous".  Click "New Discussion" to start a conversation.  Congratulations, you now have a basic forum to which anyone can post messages.

The next step is to decide how your application users map into the forum.  Read on.

## Mapping application users to forum users
Your application has Users.  So does Vanilla, the engine powering the forums.  The two user sets are compatible, but maybe not a one-to-one mapping.  Consequently, you need to explicitly define how the two map.

Laravel forums ships with three mapping strategies:
 1. One-to-one by primary key
 2. Synchronize the two on-demand
 3. Custom closure

### One-to-one mapping by primary key
This is the default.  The Vanilla user matches with the application user by primary key, so like "User.id == GDN_User.UserID". In this strategy, you must create, modify, and delete Vanilla users when you create, modify, or delete your application users.  Code like this will get you started:
```php
use \BishopB\Forum\User;
use \BishopB\Forum\UserRepository;
use \BishopB\Forum\RoleRepository;

function create_an_app_user() {
    // make this app user a member moderator
    $user = UserRepository::createWithRoles(
        [
            'Name' => 'Jane Q. Doe',
            'Password' => User::crypt_password('the-initial-password', 'vanilla'),
            'HashMethod' => 'vanilla',
        ],
        [ RoleRepository::member(), RoleRepository::moderator() ]
    );
}
```

### On-demand synchronization
This is the easiest to get going, but may not be efficient. This strategy either creates a new Vanilla user to match the application user, or updates the Vanilla user to reflect the current data in the application user. If there is no application user, optionally define a guest user.
```php
// in app/start.php
use \Illuminate\Auth\UserInterface as AppUser;
use \BishopB\Forum\User as VanillaUser;

\App::bind('BishopB\Forum\UserMapperInterface', function () {
    $mapper = new \BishopB\Forum\UserMapperSynchronicity();
    $mapper->create_guest_account = null; // when null, guests will not be able
                                          // to access the forums. Change to a 
                                          // closure to implement
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
\App::bind('BishopB\Forum\UserMapperInterface', function () {
    $mapper = new \BishopB\Forum\UserMapperByClosure();
    $mapper->setClosure(function (\Illuminate\Auth\UserInterface $user = null) {
        // do whatever you want, it should return a \BishopB\Forum\User
    });
    return $mapper;
});
```

## Views and themes
You can find all the views in the `views/themes/default` folder.  Follow the instructions in [`views/themes/default/README.md`](views/themes/default/README.md) to get started.

A word of note.  These views are right out of Vanilla and are based on [Smarty](http://www.smarty.net/).  It's not quite as easy as blade, but it's just as powerful.

## Events
Vanilla emits events during its operation, and you can use these events to react or modify how Vanilla operates.  To begin, read up on [Vanilla Plugin development](http://vanillaforums.org/docs/pluginquickstart).  Then, capture the events:
```php
\Event::listen('forum.event', function ($data) {
    // use $data according to the plugin guidelines
});
```

## Troubleshooting
Things go wrong.  There's at least a way to peek under the hood and see what the Vanilla engine is doing.  Here you go:

  * Publish the package configuration files: `php artisan config:publish bishopb/laravel-forums`
  * Edit `app/config/packages/bishopb/laravel-forums/package.php`
  * Set all these flags to `true`: `trace`, `trace-include-events`, `trace-include-queries`.
  * Check your `app/storage/logs/laravel.log` for details.

## Frequently Asked Questions
1. **What does this package provide?**  Simply, forum software for Laravel.  Using the awesome Vanilla Forums engine, your Laravel application can now quickly and easily include discussion boards.
2. **Is it free?** Yes, of course.
3. **Can it do _______**?  If the community edition of Vanilla Forums can do it, this package can do it, but might not *currently* do it.
4. **What "gaps" exist between this package and Vanilla Forums?**  This may not be a complete list: plugins.
