<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class JS
{
    const JQUERY_PATH = "/framework/core/js/jquery/jquery.min.js";
    const JQUERY_UI_PATH = "/framework/core/js/jquery/jquery-ui.min.js";
    const JQUERY_TOOLS_PATH = "/framework/core/js/jquery/jquery.tools.min.js";
    
    static $scripts = array();

    public static function clean()
    {
        self::$scripts = array();
        self::init_javascript();
        
    }

    private static function init_javascript()
    {
        if (!PageData::instance()->is_set("/page/headers/required_javascripts"))
                PageData::instance()->set("/page/headers/required_javascripts",array(Block::MARKER_KEY => "head/required_javascripts","list" => array()));
    
    }
    
    public static function require_jquery()
    {
        self::require_script(self::JQUERY_PATH); 
    }

    public static function require_jquery_ui()
    {
        self::require_jquery();
        self::require_script(self::JQUERY_UI_PATH);
        CSS::require_css_file("/".FRAMEWORK_CORE_PATH."js/jquery/css/jquery-ui.css");
    }

    public static function require_jquery_tools()
    {
        self::require_jquery();
        self::require_script(self::JQUERY_TOOLS_PATH);
    }

    public static function require_script_file($file)
    {
        if ($file instanceof File)
            $file_object = $file;
        else
            $file_object = new File($file);

        if (!$file_object->exists())
        {
            throw new Exception("Script not found : ".$file);
        }
        else
        {
            $path_with_hash = $file_object->getPath()."?hash=".md5($file_object->getModificationTime());
            self::require_script($path_with_hash);
        }
    }

    public static function require_script($script_path)
    {
        self::init_javascript();
        if (!ArrayUtils::has_value(self::$scripts,$script_path))
        {
            
            self::$scripts[$script_path] = $script_path;
            $p = array(Block::MARKER_KEY => "head/script_link","script_path" => $script_path);
            
            PageData::instance()->add("/page/headers/required_javascripts/list",$p);
        }
    }

    public static function raw($key,$script)
    {
        self::init_javascript();
        if (!ArrayUtils::has_value(self::$scripts,$key))
        {
            self::$scripts[$key] = $script;
            $p = array(Block::MARKER_KEY => "head/raw_javascript","raw_script" => $script);
            PageData::instance()->add("/page/headers/required_javascripts/list",$p);
        }
    }

    static function get_script_links()
    {
        return self::$script_links;
    }
    
    static function get_raw_scripts()
    {
        return self::$raw_scripts;
    }
        
}


?>