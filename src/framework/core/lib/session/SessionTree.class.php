<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class SessionTree
{
    function __construct()
    {
        if (session_id()=='')
            session_start();
    }

    private static function normalize_data($value)
     {
         if ($value instanceof AbstractDO)
             return ActiveRecordUtils::toArray($value);

         return $value;
     }


     public static function path_tokens($path)
     {
         $path_parts = explode("/",$path);

         $result = array();

         foreach ($path_parts as $p)
         {
             if ($p!==null && $p!=="")
                 $result[] = $p;
         }
         return $result;
     }

     public static function all_but_last_path_tokens($path)
     {
         $path_tokens = self::path_tokens($path);
         return array_splice($path_tokens, 0, count($path_tokens)-1);
     }

     public static function last_path_token($path)
     {
         $path_tokens = self::path_tokens($path);
         return $path_tokens[count($path_tokens)-1];
     }

     /*
      * Imposta un valore. L'ultima parte del path diventa la chiave.
      * Se il valore è un Tree viene creato un link.
      * Esempio :
      *
      * path : /html/head/title
      * value = "Benvenuti nel sito XYZ!!"
      */
     function set($path,$value)
     {
         $path_used = self::all_but_last_path_tokens($path);

         $current_node = &$_SESSION;

         foreach ($path_used as $p)
         {
             if (!isset($current_node[$p]))
                 $current_node[$p] = array();

             $current_node = &$current_node[$p];

         }

         if ($value instanceof Tree || $value instanceof TreeView) //copia dei dati
             $current_node[self::last_path_token($path)] = $value->get("/");
         else
             $current_node[self::last_path_token($path)] = self::normalize_data($value);
     }

     /*
      * Crea una vista sul percorso specificato.
      *
      */
     public function view($path)
     {
         if (!$this->is_set($path))
                 return null;

         return new TreeView($path,$this);
     }

     /*
      * Aggiunge un valore nella posizione corrente.
      * Se il valore è un albero viene creato un link.
      * Esempio :
      *
      * path : /html/head/keywords
      * value : ravenna
      *
      * Viene aggiunta "ravenna" alle keywords. Keywords deve essere un array.
      *
      *
      */
     function add($path,$value)
     {
         $path_parts = self::path_tokens($path);

         $current_node = &$_SESSION;

         foreach ($path_parts as $p)
         {
             if (!isset($current_node[$p]))
                 $current_node[$p] = array();
             $current_node = &$current_node[$p];
         }

         if ($value instanceof Tree || $value instanceof TreeView)  //copia dei dati
             $current_node[] = $value->get("/");
         else
             $current_node[] = self::normalize_data($value);
     }

     /*
      * Effettua il merge di un'array di valori all'interno di un'altro array.
      * La differenza rispetto ad add sta nel fondere i due array.
      */
     function merge($path,$value)
     {
         $path_parts = self::path_tokens($path);

         $current_node = &$_SESSION;

         foreach ($path_parts as $p)
         {
             if (!isset($current_node[$p]))
                 $current_node[$p] = array();
             $current_node = &$current_node[$p];
         }

         $real_value = self::normalize_data($value);
         $current_node = array_merge($current_node,$real_value);
     }

     /*
      * Rimuove le chiavi trovate nel path specificato.
      */
     function purge($path,$keys)
     {
         $path_parts = self::path_tokens($path);

         $current_node = &$_SESSION;

         foreach ($path_parts as $p)
         {
             if (!isset($current_node[$p]))
                 $current_node[$p] = array();
             $current_node = &$current_node[$p];
         }

         $current_node = array_diff($current_node,$keys);
     }

     function remove($path)
     {
         if (!$this->is_set($path)) return;
         else
         {
             $path_parts = self::all_but_last_path_tokens($path);

             $current_node = &$_SESSION;
             foreach ($path_parts as $p)
             {
                 $current_node = &$current_node[$p];
             }
             unset($current_node[self::last_path_token($path)]);

         }
     }

     /*
      * Ritorna il contenuto nella posizione specificata.
      *
      * Es:
      * path : /html/head/keywords
      * -> ritorna l'array delle keywords
      *
      * path : /html/head/description
      * -> ritorna la descrizione
      */

     function get($path,$default_value=null)
     {
         if (!$this->is_set($path))
             return $default_value;

         $path_parts = self::path_tokens($path);

         $current_node = $_SESSION;
         foreach ($path_parts as $p)
         {
             $current_node = $current_node[$p];
         }

         return $current_node;
     }

     /*
      * Ritorna true se un nodo dell'albero è stato definito, false altrimenti.
      */
     function is_set($path)
     {
         $path_parts = self::path_tokens($path);

         $current_node = $_SESSION;
         foreach ($path_parts as $p)
         {
             if (!isset($current_node[$p]))
                 return false;

             $current_node = $current_node[$p];
         }

         return true;
     }

     public function clear()
     {
         $_SESSION = array();
     }

     function dump()
     {
         var_dump($_SESSION);
     }

}



?>