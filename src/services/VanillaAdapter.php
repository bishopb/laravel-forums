<?php

namespace BishopB\Vfl;

/**
 * This class adapts the Vanilla Forums early runtime environment to
 * the running Laravel environment.  The entry point, `run`, is called
 * "early" in the Vanilla Forums process, just after the point that the
 * configuration has been loaded.  We can do basically anything to the
 * Vanilla Environment at this point.
 */
class VanillaAdapter
{
    /**
     * Run the adapter. We expect to do this on every request.
     */
    public function run()
    {
        // we've got to have mysql for Vanilla
        if (! \DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            throw new VanillaForumsRequiresMySQLException();
        }

        // map the database
        $ldc = \DB::connection()->getConfig();
        $this->set('Database.Host',              $ldc['host']);
        $this->set('Database.Name',              $ldc['database']);
        $this->set('Database.User',              $ldc['username']);
        $this->set('Database.Password',          $ldc['password']);
        $this->set('Database.CharacterEncoding', $ldc['charset']);
        $this->set(
            'Database.DatabasePrefix',
            ('' == $ldc['prefix'] ? 'GDN_' : ($ldc['prefix'] . '_GDN_') )
        );

        // force the webroot to our location
        $this->set('Garden.Domain',      url('/'));
        $this->set('Garden.WebRoot',     vfl_get_route_prefix());
        $this->set('Garden.RewriteUrls', true);
    }
}
