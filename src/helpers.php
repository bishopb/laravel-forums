<?php

/**
 * Return the prefix to use on all routes in this package.
 */
function vfl_get_route_prefix()
{
    return Config::get('vfl::routes.prefix', 'vfl');
}
