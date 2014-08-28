<?php

/**
 * Define the package routes.
 *
 * All these routes exist under $prefix, which is configurable in
 * src/config/routes.php
 */
$prefix = vfl_get_route_prefix();
Route::group([ 'prefix' => $prefix ], function () use ($prefix) {
    Route::get('test', function () {
        return 'Hello';
    });
});
