<?php

namespace BishopB\Forum;

/**
 * Perform the Vanilla setup tasks, just like someone did it manually.
 */
class VanillaSetup
{
    use VanillaHelperTrait;

    /**
     * Convince Vanilla it's installed.
     */
    public function install()
    {
        // write the static configuration file
        $this->write_config_file();

        // write the static constants file
        $this->write_constants_file();

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
     * Return an array of all files affected by this setup.
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

    /**
     * Write out the constants.
     */
    protected function write_constants_file()
    {
        $constants = [
            'PATH_CACHE' => storage_path() . '/cache',
            'PATH_THEMES' => dirname(__DIR__) . '/views/themes',
            'PATH_UPLOADS' => \Config::get('forum::paths.uploads'),
        ];

        $text = '<?php' . "\n";
        foreach ($constants as $key => $val) {
            $text .= sprintf("define('%s', %s);\n", $key, var_export($val, true));
        }

        $this->write_file($this->affected_files()['bootstrap.before'], $text);
    }
}
