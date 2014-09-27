<?php

namespace BishopB\Vfl;

use \Illuminate\Auth\UserInterface as AppUser;
use \BishopB\Vfl\User as VanillaUser;

class VflServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Routing is about to happen, define things we'll need for routing.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bishopb/vanilla-for-laravel', 'vfl', __DIR__);

		require_once __DIR__ . '/boot/helpers.php';
		require_once __DIR__ . '/boot/routes.php';
	}

	/**
	 * Register the service provider. Keep it fast.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->register(
            'Felixkiss\UniqueWithValidator\UniqueWithValidatorServiceProvider'
        );

        // providers
        /*
        $this->app->bind('BishopB\Vfl\UserMapperInterface', 'BishopB\Vfl\UserMapperById');
         */
        // FIXME: temporary
        \App::bind('BishopB\Vfl\UserMapperInterface', function () {
            $mapper = new \BishopB\Vfl\UserMapperSynchronicity();
            $mapper->create_guest_account = function () {
                return UserRepository::createWithRoles(
                    [
                        'UserID' => 1,
                        'Name' => 'Guest User',
                        'Password' => str_random(64),
                        'HashMethod' => 'random',
                    ],
                    [ RoleRepository::member() ]
                );
            };
            $mapper->create_account_for = function ($vanillaID, AppUser $user) {
                return \BishopB\Vfl\User::create([
                    'UserID' => $vanillaID,
                    'Name' => $user->lastCommaFirstName,
                    'Password' => str_random(64),
                    'HashMethod' => 'random',
                ]);
            };
            $mapper->update_account_for = function (AppUser $user, VanillaUser $vanillaUser) {
                $vanillaUser->Name = $user->lastCommaFirstName;
                $vanillaUser->save();
            };
            return $mapper;
        });

        // commands
        $this->app['vfl::commands.migrate'] = $this->app->share(function ($app) {
            return new VanillaMigrate();
        });
        $this->app['vfl::commands.connect'] = $this->app->share(function ($app) {
            return new VanillaConnect();
        });

        $this->commands('vfl::commands.migrate', 'vfl::commands.connect');
	}

	/**
	 * We have views and configuration: can't defer.
	 *
	 * @var bool
	 */
	protected $defer = false;
}
