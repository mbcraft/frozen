<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once ("AbstractLoader.class.php");
require_once ("Config.class.php");
require_once ("interfaceloader.php");


function preload($class_name)
{
    ClassLoader::instance()->load($class_name);
}
/*
 *  echo __CLASS__;   -> classe in cui è definita la funzione
 *  echo get_class($this); -> classe dell'oggetto su cui viene invocata la funzione
 *
 * Con le sottoclassi può variare!
 *
 * 
 * 
 */
class ClassLoader extends AbstractLoader
{
    const CLASS_FILENAME_SUFFIX = ".class.php";
    const CLASS_AFTER_LOAD_INTERFACE = "InitializeAfterLoad";
    const CLASS_AFTER_LOAD_METHOD = "__classLoaded";
    private static $instance = null;
    
    private static $search_path = array();

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        
        self::$instance = new ClassLoader(self::CLASS_FILENAME_SUFFIX,true,false);
        self::$instance->autoconfigure();
    }
    
    public function add_directory($dir)
    {
        if ($dir instanceof Dir)
            $path = $dir->getPath();
        else
            $path = $dir;
        
        array_push(self::$search_path, $path);
        $this->scan_from_site_root($path);
    }

    protected function autoconfigure()
    {
        if (!isset(Config::instance()->CLASS_DIRS))
            Config::instance()->CLASS_DIRS = array();
        
        self::$search_path = Config::instance()->CLASS_DIRS;
        
        $this->add_directory(DS.FRAMEWORK_CORE_PATH."lib".DS);        
        
        $this->add_directory("/lib/");
    }

    public function has_found_class($class_name)
    {
        return $this->has_found_element($class_name);
    }

    public function load($class_name)
    {
        $loaded = false;

        if ($this->has_found_element($class_name))
        {
            $path = $this->get_element_path_by_name($class_name);

            require_once($path);

            if (array_key_exists(self::CLASS_AFTER_LOAD_INTERFACE, class_implements($class_name)))
            {
                $eval_string = $class_name."::".self::CLASS_AFTER_LOAD_METHOD."('$class_name');";
                eval($eval_string);
                $this->__info(__METHOD__, "Class $class_name initialized after loading.");
            }
            $loaded = true;
            return;
        }

        $this->__warn(__METHOD__, "Classe non trovata : $class_name, using other classloaders ...");
        
    }

}

/*
 * Caricamento automatico delle classi in base al nome :)
 */
function __autoload($interface_or_class_name)
{
    try
    {
        $classloader = ClassLoader::instance();
        if ($classloader->has_found_class($interface_or_class_name))
            $classloader->load($interface_or_class_name);
        else
            if (InterfaceLoader::instance()->has_found_interface($interface_or_class_name))
                InterfaceLoader::instance()->load($interface_or_class_name);
    }
    catch (Exception $ex)
    {
        echo $ex->getMessage();
    }
}

?>