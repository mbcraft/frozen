<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/* 
 * Contiene le COSTANTI e le variabili di configurazione.
 * La differenza tra le une e le altre è che le COSTANTI una volta impostate non si possono più modificare, le variabili
 * invece si.
 * Posso utilizzare isset(Config::instance()->nome_variabile) o isset(Config::instance()->NOME_COSTANTE) per sapere se è impostata (ritorna true o false).
 * Ho volutamente scelto di utilizzare la __get per facilitare la lettura.
 *
 * scrittura : Config::instance()->NOME_COSTANTE(valore elenco valori)
 * lettura : Config::instance()->NOME_COSTANTE
 *
 * Contiene una piccola factory che inizializza l'implementazione di default per la configurazione (tramite file).
 *
 * Il guaio delle costanti definite tramite define è che se la costante non è definita viene ritornata la chiave della costante.
 * Questo è un pessimo comportamento, tramite questa classe lo si evita.
 *
 * Al momenti si comporta come una define, e permette quindi costanti e variabili GLOBALI.
 *
 * @author marco.bagnaresi
 */

function set_debug($value)
{
    if ($value===true)
        Config::instance()->DEBUG = true;
}

function is_debug()
{
    if (isset(Config::instance()->DEBUG) && Config::instance()->DEBUG === true)
        return true;
    return false;
}

class Config extends BasicObject
{
    private static $initialized = false;
    private static $instance;

    const CONFIG_DIR = "/include/config/";

    const COMMON_CONFIG = "__common";
    

    public static function __init()
    {
        self::$initialized = true;
        //__define_class("ConfigHolder", "DataHolder");
        self::$instance = new DataHolder();
    }
    
    /*
     * Nuovo da utilizzare
     */
    public static function instance()
    {
        if (!self::$initialized) self::__init();
        return self::$instance;
    }
    
    public static function has($key)
    {
        return isset(Config::instance()->$key);
    }
    
    public static function get($key)
    {
        return Config::instance()->$key;
    }

    public static function as_boolean($key)
    {
        return Config::instance()->$key=="true";
    }

    public static function as_int($key)
    {
        return (int) Config::instance()->$key;
    }

    public static function as_string($key)
    {
        return "".Config::instance()->$key;
    }

    public static function get_available_configurations()
    {
        $d = new Dir(self::CONFIG_DIR);

        $folders = $d->listFolders();

        $result = array();

        foreach ($folders as $fold)
        {
            if ($fold->getName()!=self::COMMON_CONFIG)
                $result[] = $fold->getName();
        }

        return $result;
    }

}
?>