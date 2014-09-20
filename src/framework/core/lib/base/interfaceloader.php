<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once ("AbstractLoader.class.php");
require_once ("Config.class.php");



/*
 *  echo __CLASS__;   -> classe in cui è definita la funzione
 *  echo get_class($this); -> classe dell'oggetto su cui viene invocata la funzione
 *
 * Con le sottoclassi può variare!
 *
 */
class InterfaceLoader extends AbstractLoader
{
    const INTERFACE_FILENAME_SUFFIX = ".interface.php";
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
        self::$instance = new InterfaceLoader(self::INTERFACE_FILENAME_SUFFIX,true,false);
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
        if (!isset(Config::instance()->INTERFACE_DIRS))
            Config::instance()->INTERFACE_DIRS = array();
        
        self::$search_path = Config::instance()->INTERFACE_DIRS;
        
        $this->add_directory(DS.FRAMEWORK_CORE_PATH."lib".DS);        
        
        /*
        $installed_modules = InstalledModules::get_all_installed_modules();
        
        foreach ($installed_modules as $module)
        {
            extract($module["global"]);
            
            if ($nome_categoria!=ModuleUtils::FRAMEWORK_CATEGORY_NAME && $nome_modulo!=ModuleUtils::FRAMEWORK_MODULE_NAME)
                $this->add_directory(DS.FRAMEWORK_MODULES_PATH.$module_dir.DS.$nome_categoria.DS.$nome_modulo.DS."lib".DS);
        }
         */

        $this->add_directory("/lib/");
    }

    public function has_found_interface($interface_name)
    {
        return $this->has_found_element($interface_name);
    }

    public function load($interface_name)
    {
        $loaded = false;

        if ($this->has_found_element($interface_name))
        {
            $path = $this->get_element_path_by_name($interface_name);

            require_once($path);

            if (array_key_exists(self::CLASS_AFTER_LOAD_INTERFACE, class_implements($interface_name)))
            {
                $eval_string = $interface_name."::".self::CLASS_AFTER_LOAD_METHOD."('$interface_name');";
                eval($eval_string);
                $this->__info(__METHOD__, "Interface $interface_name initialized after loading.");
            }
            $loaded = true;
            return;
        }

        $this->__warn(__METHOD__, "Interfaccia non trovata : $interface_name, using other interfaceloaders ...");
        
    }

}

?>