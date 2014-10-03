<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class LayoutFactory extends BasicObject 
{    
    public static function create($name,$data)
    {
        $loader = LayoutLoader::instance();
        if ($loader->has_found_layout($name))
        {
            $layout_path = $loader->get_layout_path_by_name($name);
            $layout = new Layout();
            $layout->__setup($layout_path,$name,new Tree($data));            
            return $layout;
        }
        else
        {
            return BlockFactory::create("errors/layout_not_found", array("layout_name"=>$name));
        }
    }
    
    public static function add_directory($dir)
    {
        LayoutLoader::instance()->add_directory($dir);
    }

    public static function can_create($name)
    {
        return LayoutLoader::instance()->has_found_layout($name);
    }
    
    public static function get_available_layouts()
    {
        return LayoutLoader::instance()->get_available_layouts();
    }
    
    public static function get_search_dirs()
    {
        return Config::instance()->LAYOUT_DIRS;
    }
}

?>