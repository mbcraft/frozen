<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Session implements IStaticTree
{
    const DEFAULT_SESSION_ENGINE = "SessionTree";
    private static $session_engine_class = self::DEFAULT_SESSION_ENGINE;
    private static $session_engine = null;

    public static function init()
    {
        self::internalInit();
    }

    public static function __setSessionEngineClass($engine_class)
    {
        self::$session_engine_class = $engine_class;
    }

    public static function __getSessionEngineClass()
    {
        return self::$session_engine_class;
    }

    /*
     * Questa funzione e' un'init interno. Inizializza l'engine se necessario e restituisce l'engine corrente.
     *
     * Ritorna l'oggetto Tree per la sessione.
     */
    private static function internalInit()
    {
        if (self::$session_engine===null)
            self::$session_engine = __create_instance (self::$session_engine_class);

        return self::$session_engine;
    }

    static function set($path,$value)
    {
        $t = self::internalInit();
        $t->set($path,$value);
    }

    static function add($path,$value)
    {
        $t = self::internalInit();
        $t->add($path,$value);
    }

    static function merge($path,$value)
    {
        $t = self::internalInit();
        $t->merge($path,$value);
    }

    static function purge($path,$keys)
    {
        $t = self::internalInit();
        $t->purge($path,$keys);
    }

    static function remove($path)
    {
        $t = self::internalInit();
        $t->remove($path);
    }

    static function view($path)
    {
        $t = self::internalInit();
        return $t->view($path);
    }

    static function get($path,$default_value=null)
    {
        $t = self::internalInit();
        return $t->get($path,$default_value);
    }

    static function clear()
    {
        $t = self::internalInit();
        $root_elements = $t->get("/");
        foreach ($root_elements as $k => $v)
        {
            if (!StringUtils::starts_with($k,"__"))
                $t->remove($k);
        }
    }

    static function is_set($path)
    {
        $t = self::internalInit();
        return $t->is_set($path);
    }

    static function save()
    {
        
    }

}
?>