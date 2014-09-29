<?php

/**
 * Return the prefix to use on all routes in this package.
 */
function forum_get_route_prefix()
{
    return Config::get('forum::routes.prefix', 'forum');
}

/**
 * If we are configured to intercept Vanilla tracing, set that up.
 */
if (\Config::get('forum::package.trace', false)) {
    function Trace($value) {
        $level = \Config::get('forum::package.trace-level', 'debug');
        call_user_func(['Log', $level], $value);
    }
}

/**
 * When Garden throws an exception, come back to here and show it in
 * Laravel.
 */
function LogException(\Exception $ex)
{
    echo \App::make('exception')->handleException($ex);
}
