<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


/*
 *  Funzione rapida per l'inclusione di blocchi, comoda da usare dentro l'html.
 */



class BlockFactory
{
    public static function create($name,$params)
    {
        $loader = BlockLoader::instance();
        if ($loader->has_found_block($name))
        {
            $block_path = $loader->get_block_path_by_name($name);
            return new Block($block_path,$name,$params);
        }
        else
        {
            return BlockFactory::create("errors/block_not_found", array("name" => $name));
        }
    }
    
    public static function clear()
    {
        BlockLoader::instance()->reset();
    }
    
    public static function add_directory($dir)
    {
        BlockLoader::instance()->add_directory($dir);
    }

    public static function can_create($name)
    {
        return BlockLoader::instance()->has_found_block($name);
    }

    public static function get_available_blocks()
    {
        return BlockLoader::instance()->get_available_blocks();
    }
    
    public static function get_search_dirs()
    {
        return Config::instance()->BLOCK_DIRS;
    }


}

?>