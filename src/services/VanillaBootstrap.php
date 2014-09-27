<?php

namespace BishopB\Vfl;

/**
 * Do what's necessary to get Vanilla's framework running.
 */
class VanillaBootstrap
{
    use VanillaHelperTrait;

    /**
     * Boot up Vanilla.
     * 
     * Much of this ripped out of Vanilla's index.php
     */
    public static function call(callable $callback)
    {
        // Vanilla and Laravel share some common global functions, like `url`
        // and `asset`.  Laravel's defintion won, so now we need to override
        // these functions to be compatible with Vanilla.
        $old_url = \App::make('url');
        \App::bind('url', function ()
        {
            return new UrlGenerator(
                \App::make('router')->getRoutes(),
                \App::make('request')
            );
        });

        // vanilla doesn't pass E_STRICT
        $old_error_reporting = error_reporting(
            E_ERROR|E_PARSE|E_CORE_ERROR|
            E_COMPILE_ERROR|E_USER_ERROR|E_RECOVERABLE_ERROR
        );

        // define the constants we need to get going
        $constants = [
            'APPLICATION'         => 'Vanilla',
            'APPLICATION_VERSION' => self::get_vanilla_version(),
            'DS'                  => '/',
            'PATH_ROOT'           => self::get_vanilla_path(),
        ];
        foreach ($constants as $key => $val) {
            if (! defined($key)) {
                define($key, $val);
            }
        }

        // alright, boot it up
        require_once(PATH_ROOT . '/bootstrap.php');

        // do the requested work
        call_user_func($callback);

        // restore our environment as much as possible
        \App::bind('url', $old_url);
        error_reporting($old_error_reporting);
    }
}
