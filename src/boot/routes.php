<?php

/**
 * Define the package routes.
 *
 * All these routes exist under $prefix, which is configurable in
 * src/config/routes.php
 */
$prefix = vfl_get_route_prefix();
Route::group([ 'prefix' => $prefix ], function () use ($prefix) {
    // default all routes through the vanilla passthru
    Route::any(
        '{slug}', [ 'uses' => '\BishopB\Vfl\PassthruController@index' ]
    )->where('slug', '^.*');
});
