<?php

namespace BishopB\Forum;

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
    public function call(callable $callback)
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
        $this->define_constants();

        // alright, boot it up
        require_once(PATH_ROOT . '/bootstrap.php');

        // recover Laravel error handling
        \App::getFacadeRoot()->startExceptionHandling();

        // do the requested work
        call_user_func($callback);

        // restore our environment as much as possible
        \App::bind('url', $old_url);
        error_reporting($old_error_reporting);
    }

    protected function define_constants()
    {
        $global_theme_path = __DIR__ . '/../views/themes';
        $local_theme_path  = app_path() . '/views/packages/bishopb/laravel-forums/themes';

        $constants = [
            'APPLICATION'         => 'Vanilla',
            'APPLICATION_VERSION' => $this->get_vanilla_version(),
            'DS'                  => '/',
            'PATH_ROOT'           => $this->get_vanilla_path(),
            'PATH_CACHE'          => storage_path() . '/cache',
            'PATH_THEMES'         => (
                file_exists($local_theme_path) ?
                $local_theme_path :
                $global_theme_path
            ),
            'PATH_UPLOADS'        => \Config::get('forum::paths.uploads'),
        ];

        foreach ($constants as $key => $val) {
            if (! defined($key)) {
                define($key, $val);
            }
        }
    }
}
