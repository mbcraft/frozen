<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa classe effettua la scansione di una serie di directory in modo ricorsivo
 * e effettua l'include di tutti i file che terminano con ".config.php".
 * E' utilizzata per caricare le configurazioni globali del framework.
 * E' la prima che viene caricata e lanciata.
 * I file di configurazione effettuano il caricamento della configurazione all'interno di Config.
 * 
 */

class FrameworkIniConfigLoader extends AbstractLoader
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
        self::$instance = new FrameworkIniConfigLoader(self::CONFIG_INI_FILENAME_SUFFIX,true,true);
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
        $this->scan_from_site_root("/".FRAMEWORK_CORE_PATH."config/");
    }
    
    public function add_directory($dir)
    {
        throw new Exception("Impossibile aggiungere una directory di configurazione del framework.");
    }
}

?>