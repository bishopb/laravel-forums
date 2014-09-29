<?php

/**
 * These settings affect the forum operation.
 * For the most part, these settings are passed directly to Vanilla Forum engine.
 */
return [
    /**
     * @param string title
     *
     * The title that appears on every page in the forum.
     */
    'title' => 'Laravel Forums',

    /**
     * @param string default-controller
     *
     * Given no other route components, this is the first page the user sees.
     */
    'default-controller' => 'discussions',
];
