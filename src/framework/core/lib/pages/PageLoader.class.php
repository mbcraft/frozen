<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/**
 * Description of __PageAutoloaderclass
 *
 * @author frostlabgate
 */
class PageLoader extends AbstractLoader
{
    const PAGE_FILENAME_SUFFIX = ".page.php";
    private static $instance = null;

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        //suffisso .page.php, scan recursively, keep dir as namespaces
        self::$instance = new PageLoader(self::PAGE_FILENAME_SUFFIX,true,true);
        //self::$instance->autoconfigure();
    }
    
    public function add_directory($dir)
    {
        if ($dir instanceof Dir)
            $my_dir_path = $dir->getPath();
        else
            $my_dir_path = $dir;
        
        if (!isset(Config::instance()->PAGE_DIRS))
                Config::instance()->PAGE_DIRS = array();
        
        Config::instance()->PAGE_DIRS[] = $my_dir_path;
        
        $this->scan_from_site_root($my_dir_path);
    }

    public final function has_found_page($name)
    {
        return $this->has_found_element($name);
    }

    public final function get_page_path_by_name($name)
    {
        return $this->get_element_path_by_name($name);
    }
}
?>