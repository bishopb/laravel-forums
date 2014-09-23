<?php

namespace BishopB\Vfl;

/**
 * This class adapts the Vanilla Forums early runtime environment to
 * the running Laravel environment.  The entry point, `run`, is called
 * "early" in the Vanilla Forums process, just after the point that the
 * configuration has been loaded.  We can do basically anything to the
 * Vanilla Environment at this point.
 */
class VanillaAdapter extends AbstractVanillaService
{
    /**
     * How to run this adapter. This will be handed over to Vanilla.
     */
    public static function code()
    {
        return '<?php with(new \BishopB\Vfl\VanillaAdapter)->run();';
    }

    /**
     * Run the adapter. We expect to do this on every request.
     */
    public function run()
    {
        $this->adapt_db();
        $this->adapt_request();
    }

    /**
     * Adapt Vanilla configuration to our current database.
     */
    public function adapt_db()
    {
        $connection = \DB::connection();
        if (! $connection instanceof \Illuminate\Database\MySqlConnection) {
            throw new VanillaForumsRequiresMysqlException(
                trans('Cannot use Vanilla with ') . get_class($connection)
            );
        }

        $ldc = $connection->getConfig();
        $this->set('Database.Host',              $ldc['host']);
        $this->set('Database.Name',              $ldc['database']);
        $this->set('Database.User',              $ldc['username']);
        $this->set('Database.Password',          $ldc['password']);
        $this->set('Database.CharacterEncoding', $ldc['charset']);
        $this->set(
            'Database.DatabasePrefix',
            ('' == $ldc['prefix'] ? 'GDN_' : ($ldc['prefix'] . '_GDN_') )
        );
    }

    /**
     * Adapt Vanilla to our current domain
     */
    public function adapt_request()
    {
        $this->set('Garden.Domain',      url('/'));
        $this->set('Garden.WebRoot',     vfl_get_route_prefix());
        $this->set('Garden.RewriteUrls', true);
    }
}
