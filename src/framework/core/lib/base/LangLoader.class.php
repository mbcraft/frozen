<?

/* This software is released under the BSD license. Full text at project root -> license.txt */

class LangLoader extends AbstractLoader
{
    private static $instance = null;
    const LANG_INI_FILENAME_SUFFIX = ".lang.ini";

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        self::$instance = new LangLoader(self::LANG_INI_FILENAME_SUFFIX,false,true);
        self::$instance->autoconfigure();
    }

    protected function element_found($name)
    {
        $path = $this->get_element_path_by_name($name);

        $f = new File($path);
        
        $props = PropertiesUtils::readFromFile($f, false);


    }

    protected function autoconfigure()
    {
        $this->scan_from_site_root("/framework/core/lang/");
        $this->scan_from_site_root("/include/lang/");
    }
    
    public function add_directory($dir)
    {
        throw new Exception("Impossibile aggiungere una directory di configurazione dell'app.");
    }
}

?>