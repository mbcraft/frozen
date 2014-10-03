<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

require_once(FRAMEWORK_CORE_PATH."/lib/request/Host.class.php");

class AppIniConfigLoader extends AbstractLoader
{
    private static $instance = null;
    const CONFIG_INI_FILENAME_SUFFIX = ".config.ini";

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        self::$instance = new AppIniConfigLoader(self::CONFIG_INI_FILENAME_SUFFIX,false,true);
        self::$instance->autoconfigure();
    }

    protected function element_found($name)
    {
        $path = $this->get_element_path_by_name($name);

        $props = parse_ini_file($path,false);

        foreach ($props as $k => $v)
            Config::instance()->$k = $v;


    }

    protected function autoconfigure()
    {
        $this->scan_from_site_root("/include/config/__common/");
        $this->scan_from_site_root("/include/config/".Host::current()."/");
    }
    
    public function add_directory($dir)
    {
        throw new Exception("Impossibile aggiungere una directory di configurazione dell'app.");
    }

}

?>