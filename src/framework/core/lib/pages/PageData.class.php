<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Questa classe rappresenta il risultato di una richiesta HTTP.
 * E' un semplice albero di dati manipolabile tramite metodi.
 */


/*
 * Funzioni utilizzabili :
 * 
 * get/set  -> legge il valore/scrive il valore
 * merge/purge -> fonde gli array/rimuove gli array
 * add/remove -> aggiunge ad un array/rimuove da un array
 * clear    -> cancella tutti i dati
 */

class PageData
{
    private static $my_tree=null;
        
    static function instance()
    {
        self::init();
        return self::$my_tree;
    }
    
    private static function init()
    {
        if (self::$my_tree === null)
            self::$my_tree = new Tree();
    }

    public static function dump()
    {
        var_dump(self::$my_tree->get("/"));
    }
    
}

?>