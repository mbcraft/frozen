<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Language
 *
 * @author marco
 */
class Language 
{
    const SESSION_LANGUAGE_PATH = "/current_lang";
    
    static $default_language = "it";
    static $supported_languages = array("it","en","es","fr","de");
    
    static $enabled_languages = array("it","en","es");
    
    static $current_language = null;
    
    static function setCurrent($lang)
    {
       if (ArrayUtils::has_value(self::$supported_languages,$lang))
       {
           Session::set(self::SESSION_LANGUAGE_PATH, $lang);
       }
       else
        self::initDefault ();
    }
    
    private static function __checkLang($l)
    {
        if (!ArrayUtils::has_value(self::$supported_languages,$l))
            throw new InvalidDataException("Unsupported language : ".$lang);
    }
    
    private static function checkSupportedLanguage($lang)
    {
        $all_lang = explode(",", $lang);

        foreach ($all_lang as $k => $l)
            self::__checkLang ($l);
        
    }
    
    private static function initDefault()
    {
        if (isset(Config::instance()->DEFAULT_LANGUAGE) && self::checkSupportedLanguage(Config::instance()->DEFAULT_LANGUAGE))
            self::$default_language = Config::instance()->DEFAULT_LANGUAGE;
        
        if (isset(Config::instance()->ENABLED_LANGUAGES) && self::checkSupportedLanguage(Config::instance()->ENABLED_LANGUAGES))
            self::$enabled_languages = explode(",",Config::instance()->ENABLED_LANGUAGES); 
        
        Session::set(self::SESSION_LANGUAGE_PATH, self::$default_language);
    }
    
    static function isEnabled($l)
    {
        return ArrayUtils::has_value(self::$enabled_languages,$l);
    }
    
    static function getCurrent()
    {
        if (!Session::is_set(self::SESSION_LANGUAGE_PATH))
            self::initDefault();    
        return Session::get(self::SESSION_LANGUAGE_PATH);
        
    }
    
    static function getDefault()
    {
        return self::$default_language;
    }
}

?>