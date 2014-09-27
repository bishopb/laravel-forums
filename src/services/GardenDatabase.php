<?php

namespace BishopB\Forum;

/**
 * Our own Database, which will be injected into Vanilla.
 */
class GardenDatabase extends \Gdn_Database
{
    public function Query($Sql, $InputParameters = NULL, $Options = [])
    {
        // log if we want to
        if (\Config::get('forum::package.trace-include-queries', false)) {
            Trace([
                'sql' => $Sql,
                'params' => $InputParameters,
                'options' => $Options,
            ]);
        }

        // defer
        $rc = parent::Query($Sql, $InputParameters, $Options);

        // exception?
        return $rc;
    }
}
