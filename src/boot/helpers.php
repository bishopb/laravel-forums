<?php

/**
 * Return the prefix to use on all routes in this package.
 */
function vfl_get_route_prefix()
{
    return Config::get('vfl::routes.prefix', 'vfl');
}

/**
 * If we are configured to intercept Vanilla tracing, set that up.
 */
if (\Config::get('vfl::package.trace', false)) {
    function Trace($value) {
        $level = \Config::get('vfl::package.trace-level', 'debug');
        call_user_func(['Log', $level], $value);
    }
}
