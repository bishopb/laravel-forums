<?php

namespace BishopB\Vfl;

/**
 * We need to provide the Vanilla implementation of these functions that
 * Laravel overwrote.
 * See for example:
 *   1. <vanilla>/library/core/functions.general.php
 *   2. <laravel>/src/Illuminate/Support/helpers.php
 */
class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    function to($path, $parameters = null, $secure = false)
    {
        return parent::to(
            vfl_get_route_prefix() . '/' . $path,
            (is_array($parameters) ? $parameters : []),
            $secure
        );
    }

    function asset($path)
    {
        return parent::to(
            vfl_get_route_prefix() . $path,
            [],
            false
        );
    }
}

