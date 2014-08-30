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
     * Install the code needed to inject ourselves into Vanilla.
     */
    public static function install($path)
    {
        $p = $path . '/conf/bootstrap.early.php';
        if (! file_exists($p)) {
            file_put_contents($p, '<?php return \BishopB\Vfl\VanillaAdapter::run();');
        }
    }

    /**
     * Run the adapter. We expect to do this on every request.
     */
    public static function run()
    {
        // tell Garden we're installed
        static::set('Garden.Installed', true);

        // we've got to have mysql for Vanilla
        if (! \DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            throw new VanillaForumsRequiresMySQLException();
        }

        // map the database
        $ldc = \DB::connection()->getConfig();
        static::set('Database.Host',              $ldc['host']);
        static::set('Database.Name',              $ldc['database']);
        static::set('Database.User',              $ldc['username']);
        static::set('Database.Password',          $ldc['password']);
        static::set('Database.CharacterEncoding', $ldc['charset']);
        static::set(
            'Database.DatabasePrefix',
            ('' == $ldc['prefix'] ? 'GDN_' : ($ldc['prefix'] . '_GDN_') )
        );
    }

    // PROTECTED API

    protected static function set($key, $value)
    {
        \Gdn::Config()->Set($key, $value, true /*overwrite*/, false /*dont persist*/);
    }
}
