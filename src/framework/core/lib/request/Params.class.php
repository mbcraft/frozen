<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Questa classe viene utilizzata per accedere ai parametri dei vari oggetti.
 * Non uso direttamente $_POST perchè in questo modo riduco i passaggi.
 */

/*
 * E' necessario effettuare il refactoring di questa classe per prendere e scrivere i parametri direttamente dalla
 * chiamata in cima al call stack. Non servono quindi push ,pop e peek.
 * */

/*
 * Questa classe implementa uno stack di parametri.
 * Viene utilizzata per contenere i dati delle chiamate ricevute dal browser o
 * effettuate internamente tramite call.
 *
 * */
class Params
{
    private $loaded = false;
    private $params = array();

    private static $call_stack = array();

    const NOTSET_KEY_PREFIX = "__not_set_";

    private static function __is_notset_key($key)
    {
        if (StringUtils::starts_with($key,self::NOTSET_KEY_PREFIX))
            return true;
        else
            return false;
    }

    private static function __get_notset_key($key)
    {
        return substr($key,strlen(self::NOTSET_KEY_PREFIX));
    }

    public static function push()
    {
        array_push(self::$call_stack,new Params());
    }

    public static function pop()
    {
        if (count(self::$call_stack)===0) throw new IllegalStateException("Lo stack delle chiamate e' vuoto!! Impossibile eseguire Params::pop");
        return array_pop(self::$call_stack);
    }

    private static function peek()
    {
        if (count(self::$call_stack)===0)
            self::push();

        return array_last(self::$call_stack);
    }
    /*
     * Per importare le variabili all'interno dei params
     */

    public static function set_loaded()
    {
        return self::peek()->loaded;
    }

    public static function is_loaded()
    {
        self::peek()->loaded = true;
    }

    public static function importFromGet($override_existing=false)
    {
        self::importFromArray($_GET,$override_existing);
    }

    public static function importFromPost($override_existing=false)
    {
        self::importFromArray($_POST,$override_existing);
    }

    public static function importFromCookie($override_existing=false)
    {
        self::importFromArray($_COOKIE,$override_existing);
    }
    
    public static function importFromArray($data,$override_existing=false)
    {
        foreach ($data as $key => $value)
        {
            if (self::__is_notset_key($key))
            {
                if (!isset($data[self::__get_notset_key($key)]))
                    self::set(self::__get_notset_key($key),$value);
            }
            else
                if (!self::is_set($key) || $override_existing)
                    self::set ($key, $value);
        }
    }
        
    public static function importFromXml()
    {
        throw new NotImplementedException("metodo importFromXml non ancora implementato!");
    }
    
    private static function set($key,$value)
    {
        self::peek()->params[$key] = $value;
    }
    
    public static function is_set($key)
    {
        return isset(self::peek()->params[$key]);
    }

    public static function get_or_empty($key)
    {
        if (isset(self::peek()->params[$key]))
            return Params::get($key);
        else
            return "";
    }

    public static function get($key)
    {
        return self::peek()->params[$key];
    }
    
    public static function keys()
    {
        return array_keys(self::peek()->params);
    }
    
    public static function clear()
    {
        self::peek()->loaded = false;
        self::peek()->params = array();
    }

    public static function all()
    {
        return self::peek()->params;
    }

    private static function __real_value($value)
    {
        if ($value=="false") return false;
        if ($value=="true") return true;
        if (is_numeric($value)) return 0+$value;

        return $value;
    }
}

?>