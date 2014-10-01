<?php

namespace BishopB\Forum;

/**
 * Perform the Vanilla setup tasks, just like someone did it manually.
 */
class VanillaSetup
{
    use VanillaHelperTrait;

    /**
     * Convince Vanilla it's installed.  This writes out static code and config,
     * some of which will be overwritten at run-time to reflect the latest
     * values.  We have to write these out statically to convince Vanilla
     * it's installed.
     */
    public function install()
    {
        // create cache structure
        $this->create_directories();

        // write the static configuration file
        $this->write_config_file();

        // arrange for Vanilla to call on our code at runtime
        $this->write_file(
            $this->affected_files()['bootstrap.early'],
            VanillaAdapter::code()
        );
    }

    /**
     * Reset Vanilla back to an uninstalled state.
     */
    public function uninstall()
    {
        foreach ($this->affected_files() as $file) {
            unlink($file);
        }
    }

    /**
     * Return an array of all Vanilla files affected by this setup.
     */
    public function affected_files()
    {
        $base = $this->get_vanilla_path();
        return [
            'config'           => $base . '/conf/config.php',
            'bootstrap.before' => $base . '/conf/bootstrap.before.php',
            'bootstrap.early'  => $base . '/conf/bootstrap.early.php',
        ];
    }

    /**
     * Create any needed directories.
     */
    protected function create_directories()
    {
        $paths = [
            storage_path() . '/cache/Smarty',
            storage_path() . '/cache/Smarty/cache',
            storage_path() . '/cache/Smarty/compile',
        ];
        array_map(
            function ($path) {
                if (! file_exists($path)) {
                    $ok = mkdir($path, 0777);
                    if (! $ok) {
                        throw new VanillaForumsSetupException(
                            'Cannot create required directory: ' . $path
                        );
                    }
                }
            },
            $paths
        );
    }

    /**
     * Write a basic Vanilla configuration file.
     */
    protected function write_config_file()
    {
        $html = '<?php if (!defined("APPLICATION")) exit();' . "\n";

        // start with base settings
        $settings = [
            'Conversations.Version' => $this->get_vanilla_version(),
            'EnabledApplications.Conversations' => 'conversations',
            'EnabledApplications.Vanilla' => 'vanilla',
            'EnabledPlugins.HtmLawed' => 'HtmLawed',
            'Garden.Title' => trans('Vanilla 2 for Laravel 4'),
            'Garden.Cookie.Salt' => \Config::get('app.key'),
            'Garden.Cookie.Domain' => '',
            'Garden.Registration.ConfirmEmail' => true,
            'Garden.Email.SupportName' => \Config::get('mail.from.name'),
            'Garden.InputFormatter' => 'Html',
            'Garden.Version' => $this->get_vanilla_version(),
            'Garden.RewriteUrls' => true,
            'Garden.CanProcessImages' => function_exists('gd_info'),
            'Garden.SystemUserID' => User::firstOrFail()->getKey(),
            'Garden.Registration.Method' => 'Basic',
            'Garden.Installed' => true,
            'Routes.DefaultController' => 'discussions',
            'Vanilla.Version' => $this->get_vanilla_version(),
        ];

        // add in database settings (we've got a helper that does this work
        // already)
        $adapter = new VanillaAdapter();
        $settings += $adapter->get_database_settings();

        // set those into the html
        foreach ($settings as $key => $value) {
            $html .= $this->setting($key, $value);
        }

        // write the file
        $this->write_file($this->affected_files()['config'], $html);
    }

    /**
     * Generate a configuration line for the given dot-notation key and value.
     */
    protected function setting($key, $value)
    {
        $html = '$Configuration';
        foreach (explode('.', $key) as $part) {
            $html .= sprintf('["%s"]', $part);
        }
        $html .= sprintf("=%s;\n", var_export($value, true));
        return $html;
    }

    /**
     * Stuff data into a file, with some error checking.
     */
    protected function write_file($path, $content)
    {
        $retc = file_put_contents($path, $content);
        if (false === $retc || $retc !== strlen($content)) {
            throw new VanillaForumsSetupException('Could not install file ' . $path);
        }
    }
}
