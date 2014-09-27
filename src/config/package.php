<?php

/**
 * General package configuration values.
 */
return [
    /**
     * Vanilla has a facility for debugging actions through calls to its
     * "Trace" function.  Enabling this option hooks us into that trace
     * and redirects them to the Laravel log.  This can be handy if something
     * in Vanilla isn't working.
     *
     * @param boolean trace
     */
    'trace' => false,

    /**
     * The logging level used to record trace.  If `trace` is false, this
     * has no effect.  If `trace` is true, the level given is used.  Possible
     * levels are: debug, info, notice, warning, error, critical, and alert
     */
    'trace-level' => 'debug',

    /**
     * If you would like to see the events that Vanilla's firing, enable
     * `trace-include-events`.  This has no effect unless `trace` is on.
     */
    'trace-include-events' => false,

    /**
     * If you would like to see the database queries that Vanilla's making, enable
     * `trace-include-queries`.  This has no effect unless `trace` is on.
     */
    'trace-include-queries' => false,
];
