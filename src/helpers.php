<?php

/**
 * Return the prefix to use on all routes in this package.
 */
function vanilla_get_route_prefix()
{
    return \Config::get('vanilla::routes.prefix', 'vanilla');
}
