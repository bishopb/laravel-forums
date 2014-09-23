<?php

namespace BishopB\Vfl;

/**
 * Perform the Vanilla setup tasks, just like someone did it manually.
 */
class VanillaSetup extends AbstractVanillaService
{
    /**
     * Convince Vanilla it's installed.
     */
    public function install()
    {
        // check for prior installs
        foreach ($this->installed_files() as $file) {
            if (file_exists($file)) {
                throw new VanillaForumsSetupException('Already installed');
            }
        }

        // arrange for Vanilla to call on our code
        $map = [
            'early' => '<?php with(new \BishopB\Vfl\VanillaSetup())->once();',
            'late'  => \BishopB\Vfl\VanillaAdapter::code(),
        ];
        foreach ($map as $step => $code) {
            $path = sprintf(
                '%s/conf/bootstrap.%s.php', $this->getVanillaPath(), $step
            );
            $retc = file_put_contents($path, $code);
            if (false === $retc || $retc !== strlen($code)) {
                throw new VanillaForumsSetupException('Could not install file ' . $path);
            }
        }

        // boot up to get the one-time setup stuff to run
        $boot = new VanillaBootstrap();
    }

    /**
     * Unconvince Vanilla it's installed.
     */
    public function uninstall()
    {
        foreach ($this->installed_files() as $file) {
            if (file_exists($p)) {
                unlink($p);
            }
        }
    }

    /**
     * Code we need to run once in order to get Vanilla setup.
     *
     * Refer to Vanilla's SetupController::Configure() for the steps that need
     * to happen, and that we need to emulate here.
     *
     * This stuff needs to run in the context of Vanilla.
     */
    public function once()
    {
        // assert: we are running inside of Vanilla's bootstrap
        $adapter = new VanillaAdapter();
        $adapter->adapt_db();

        // get Garden ready
        \Gdn::FactoryInstall(\Gdn::AliasApplicationManager, 'Gdn_ApplicationManager');
        \Gdn_Autoloader::Attach(\Gdn_Autoloader::CONTEXT_APPLICATION);
        \Gdn::FactoryInstall(\Gdn::AliasThemeManager, 'Gdn_ThemeManager');
        \Gdn::FactoryInstall(\Gdn::AliasPluginManager, 'Gdn_PluginManager');

        // install the schema
        \Gdn::FactoryInstall(
            \Gdn::AliasDatabase, 'Gdn_Database', NULL, \Gdn::FactorySingleton, array('Database')
        );
        \Gdn::FactoryInstall('MySQLDriver', 'Gdn_MySQLDriver', NULL, \Gdn::FactoryInstance);
        \Gdn::FactoryInstall('MySQLStructure', 'Gdn_MySQLStructure', NULL, \Gdn::FactoryInstance);
        require PATH_APPLICATIONS . '/dashboard/settings/structure.php';

        // FIXME: there is more

        // all done with the once stuff, don't do it again
        unlink($this->getVanillaPath() . '/conf/bootstrap.early.php');
    }

    // PROTECTED API

    protected function installed_files()
    {
        return [
            $this->getVanillaPath() . '/conf/bootstrap.early.php',
            $this->getVanillaPath() . '/conf/bootstrap.late.php',
        ];
    }
}
