<?php
namespace Laysense\Dns;

class Install
{
    const WEBMAN_PLUGIN = true;

    /**
     * @var array
     */
    protected static $pathRelation = array (
  'config/plugin/laysense/dns' => 'config/plugin/laysense/dns',
);

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        static::installByRelation();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        self::uninstallByRelation();
    }

    /**
     * installByRelation
     * @return void
     */
    public static function installByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            if ($pos = strrpos($dest, '/')) {
                $parent_dir = base_path().'/'.substr($dest, 0, $pos);
                if (!is_dir($parent_dir)) {
                    mkdir($parent_dir, 0777, true);
                }
            }
            //symlink(__DIR__ . "/$source", base_path()."/$dest");
            copy_dir(__DIR__ . "/$source", base_path()."/$dest");
            echo "Create $dest
";
        }
        copy(__DIR__ .'/resource/Dns.php',base_path().'/vendor/workerman/workerman/Protocols/Dns.php');
        echo "Create DNS Protocol Successfully";
        copy(__DIR__ .'/resource/DnsProcess.php',base_path().'/process/DnsProcess.php');
        echo "Create DNS Process Successfully";
        copy(__DIR__ .'/resource/DnsController.php',base_path().'/app/controller/DnsController.php');
        echo "Create Dns Controller Successfully";
    }

    /**
     * uninstallByRelation
     * @return void
     */
    public static function uninstallByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            $path = base_path()."/$dest";
            if (!is_dir($path) && !is_file($path)) {
                continue;
            }
            echo "Remove $dest
";
            if (is_file($path) || is_link($path)) {
                unlink($path);
                continue;
            }
            remove_dir($path);
        }
    }
    
}