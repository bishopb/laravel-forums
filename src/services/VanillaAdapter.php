<?php

namespace BishopB\Forum;

/**
 * This class adapts the Vanilla Forums early runtime environment to
 * the running Laravel environment.  The entry point, `run`, is called
 * "early" in the Vanilla Forums process, just after the point that the
 * configuration has been loaded.  We can do basically anything to the
 * Vanilla Environment at this point.
 */
class VanillaAdapter
{
    use VanillaHelperTrait;

    /**
     * How to run this adapter. This will be handed over to Vanilla.
     */
    public static function code()
    {
        return '<?php with(new \BishopB\Forum\VanillaAdapter)->run();';
    }

    /**
     * Run the adapter. We expect to do this on every request.
     */
    public function run()
    {
        $this->adapt_db();
        $this->adapt_request();
        $this->adapt_pluginmanager();
        $this->adapt_smarty();
        $this->adapt_config();
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

        foreach ($this->get_database_settings() as $key => $value) {
            $this->set($key, $value);
        }

        \Gdn::FactoryInstall(
            \Gdn::AliasDatabase, '\BishopB\Forum\GardenDatabase',
            NULL, \Gdn::FactorySingleton, [ 'Database' ]
        );
    }

    /**
     * Get the database configuration values as an array of Vanilla key => value.
     */
    public function get_database_settings()
    {
        $settings = [];

        $c = \DB::connection();
        $settings['Database.Host']              = $c->getConfig('host');
        $settings['Database.Name']              = $c->getConfig('database');
        $settings['Database.User']              = $c->getConfig('username');
        $settings['Database.Password']          = $c->getConfig('password');
        $settings['Database.CharacterEncoding'] = $c->getConfig('charset');
        $settings['Database.DatabasePrefix']    = (
            '' == $c->getConfig('prefix') ?
            'GDN_' :
            ($c->getConfig('prefix') . '_GDN_')
        );

        return $settings;
    }

    /**
     * Adapt Vanilla to our current domain
     */
    public function adapt_request()
    {
        \Gdn::FactoryInstall(
            \Gdn::AliasRequest, '\BishopB\Forum\GardenRequest',
            NULL, \Gdn::FactoryRealSingleton, 'Create'
        );
    }

    /**
     * Hook ourselves into Vanilla's event system.
     */
    public function adapt_pluginmanager()
    {
        \Gdn::FactoryInstall(
            \Gdn::AliasPluginManager, '\BishopB\Forum\GardenPluginManager'
        );
    }

    /**
     * Hook ourselves into Vanilla's Smarty.
     * PS: Smarty sux ;)
     */
    public function adapt_smarty()
    {
        \Gdn::FactoryInstall('ViewHandler.tpl', '\BishopB\Forum\GardenSmarty');
    }

    /**
     * Inject configuration values.
     */
    public function adapt_config()
    {
        $map = [
            'forum::forum.title'              => 'Garden.Title',
            'forum::forum.default-controller' => 'Routes.DefaultController',
            'mail.from.address'               => 'Garden.Email.SupportAddress',
            'mail.from.name'                  => 'Garden.Email.SupportName',
        ];
        foreach ($map as $ours => $theirs) {
            if (\Config::get($ours, false)) {
                $this->set($theirs, \Config::get($ours));
            }
        }
    }
}
