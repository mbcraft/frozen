<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class LayoutLoader extends AbstractLoader
{
    const LAYOUT_FILENAME_SUFFIX = ".layout.php";
    private static $instance = null;

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    
    private static function init()
    {
        self::$instance = new LayoutLoader(self::LAYOUT_FILENAME_SUFFIX,true,false);
    }

    public function add_directory($dir)
    {
        if ($dir instanceof Dir)
            $path = $dir->getPath();
        else
            $path = $dir;
        
        if (!isset(Config::instance()->LAYOUT_DIRS))
            Config::instance ()->LAYOUT_DIRS = array();
        
        Config::instance()->LAYOUT_DIRS[] = $path;
        
        $this->scan_from_site_root($path);
    }

    public final function has_found_layout($name)
    {
        return $this->has_found_element($name);
    }

    public final function get_available_layouts()
    {
        return $this->get_element_keys();
    }
    
    public final function get_layout_path_by_name($name)
    {
        return $this->get_element_path_by_name($name);
    }

}


?>