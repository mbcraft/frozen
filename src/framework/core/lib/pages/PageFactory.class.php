<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

function start_snippet($conditions)
{
    Snippet::start($conditions);
}

function end_snippet()
{
    Snippet::end();
}

class PageFactory extends BasicObject
{
    private static $pages = array();

    public static function create($name,$parent_context)
    {
        $loader = PageLoader::instance();
        if ($loader->has_found_page($name))
        {
            $page_path = $loader->get_page_path_by_name($name);
            $page = new Page();
            $page->__setup($page_path,$name);

            self::$pages[$name] = $page;
        }
        else
        {
            $page = BlockFactory::create("errors/page_not_found", $parent_context);
        }

        //ritorno la pagina
        return $page;

    }
    
    public static function add_directory($dir)
    {
        PageLoader::instance()->add_directory($dir);
        
    }

    public static function can_create($name)
    {
        return PageLoader::instance()->has_found_page($name);
    }

    public static function get_page_list()
    {
        return PageLoader::instance()->get_element_keys();
    }
}
?>