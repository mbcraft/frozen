<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/**
 * Description of __BlockAutoloader
 *
 * @author frostlabgate
 */
class BlockLoader extends AbstractLoader
{
    const BLOCK_FILENAME_SUFFIX = ".block.php";
    private static $instance = null;

    public static function instance()
    {
        if (self::$instance==null)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        self::$instance = new BlockLoader(self::BLOCK_FILENAME_SUFFIX,true,true);
    }

    /*
     * Lo devo chiamare per ogni modulo installato.
     */
    public function add_directory($dir)
    {
        if ($dir instanceof Dir)
            $path = $dir->getPath();
        else
            $path = $dir; 
        
        $this->scan_from_site_root($path);
    }

    public final function has_found_block($name)
    {
        return $this->has_found_element($name);
    }

    public final function get_block_path_by_name($name)
    {
        return $this->get_element_path_by_name($name);
    }

    public final function get_available_blocks()
    {
        return $this->get_element_keys();
    }

}
?>