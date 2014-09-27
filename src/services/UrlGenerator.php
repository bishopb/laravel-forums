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
    public function to($path, $parameters = null, $secure = false)
    {
        return parent::to(
            $this->rewrite_url($path),
            (is_array($parameters) ? $parameters : []),
            $secure
        );
    }

    public function asset($path, $secure = null)
    {
        return parent::to($this->rewrite_url($path), [], false);
    }

    private function rewrite_url($path)
    {
        if (starts_with($path, 'http') || starts_with($path, '//')) {
            return $path;
        }

        return vfl_get_route_prefix() . '/' . $path;
    }
}

