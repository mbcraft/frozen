<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa classe serve per effettuare il caricamento di tutti i CSS della pagina all'interno dell'header.
 * e gestire il discorso dei moduli (rendering CSS).
 */

class CSS
{
    private static $css_elements = array();
    private static $css_dirs = array();
    
    const MEDIA_ALL = "all";
    const MEDIA_SCREEM = "screen"; 
    const MEDIA_PRINT = "print"; 
    const MEDIA_PROJECTION = "projection";
    const MEDIA_SPEECH = "speech";
    const MEDIA_BRAILLE = "braille";
    const MEDIA_EMBOSSED = "embossed";
    const MEDIA_HANDHELD = "handheld";
    const MEDIA_TTY = "tty";
    const MEDIA_TV = "tv";

    public static function clean()
    {
        self::$css_elements = array();
        self::$css_dirs = array();
        self::init_css();
    }
    
    public static function reset()
    {
        self::require_css_file("/framework/core/css/reset_min.css");
    }
    
    private static function init_css()
    {
        if (!PageData::instance()->is_set("/page/headers/required_css_files"))
            PageData::instance()->set("/page/headers/required_css_files",array(Block::MARKER_KEY => "head/required_css_files","css_file_list" => array()));
    
    }
    
    private static function init_css_inline()
    {
        if (!PageData::instance()->is_set("/page/headers/required_css_elements"))
            PageData::instance()->set("/page/headers/required_css_elements",array(Block::MARKER_KEY => "head/required_css_elements","css_element_list" => array()));
    
    }
    
    public static function get_loaded_css()
    {
        return count(self::$css_elements);
    }

    public static function debug()
    {
        self::require_css_file("/framework/core/css/debug.css");
    }

    public static function require_css_inline($css_text,$media = CSS::MEDIA_ALL)
    {
        self::init_css_inline();
        if (!ArrayUtils::has_value(self::$css_elements,$css_text))
        {
            self::$css_elements[] = $css_text;
            PageData::instance()->add("/page/headers/required_css_elements/css_element_list",array("text" => $css_text,"media" => $media));
        }
    }
    
    public static function require_css($css_path,$media = CSS::MEDIA_ALL)
    {
        self::init_css();
        if (!ArrayUtils::has_value(self::$css_elements,$css_path))
        {
            self::$css_elements[] = $css_path;
            PageData::instance()->add("/page/headers/required_css_files/css_file_list",array("path" => $css_path,"media" => $media));
        }
    }

    public static function require_css_file($file,$media = CSS::MEDIA_ALL)
    {      
        if (!$file instanceof File) throw new InvalidDataException("Il parametro non è di tipo file!!");
        if (!$file->exists()) throw new IllegalStateException("Css non trovato!! : ".$file->getPath());
        else
        {
            $path_with_hash = $file->getPath()."?hash=".md5($file->getModificationTime());
            self::require_css($path_with_hash,$media);
        }
    }

    public static function load_from_dir($dir)
    {
        if ($dir instanceof Dir)
            $my_dir = $dir;
        else
            $my_dir = new Dir($dir);
                
        self::$css_dirs[] = $my_dir;
        
        //CSS_DIRS
        if ($my_dir->exists() && $my_dir->isDir())
        {
            $file_list = $my_dir->listFiles();
            foreach ($file_list as $f)
            {
                if ($f->isFile() && $f->getExtension()=="css")
                {
                    self::require_css_file($f);
                }
            }
        }
        else
        {
            Log::warn("load_from_dir", "Impossibile caricare i css dalla directory : ".$my_dir->getName());
        }
        
    }

}

?>