vanilla-for-laravel
===================

Laravel 4 package of [Vanilla Forums](https://github.com/vanilla/vanilla).

Installation
------------
You need to make two changes to your `composer.json`:
1. Add this package to your `require`.
2. Add the Vanilla Forums repository to `repositories`.

Your `composer.json` should contain at a minimum:
```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/vanilla/vanilla" }
],
"require": {
    "bishopb/vanilla-for-laravel": "dev-master@dev"
}
```
Why this?  Vanilla Forums (on which we obviously depend) isn't in Packagist and, since [Composer doesn't resolve dependencies' repositories](https://getcomposer.org/doc/faqs/why-can't-composer-load-repositories-recursively.md), you have to add the Vanilla Forums repository to your `composer.json` manually.
