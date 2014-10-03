<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

interface IStaticTree
{
   static function set($path,$value);
   
    static function add($path,$value);
    
    static function merge($path,$value);
    
    static function purge($path,$keys);
    
    static function remove($path);
    
    //static function view($path);
    
    static function get($path,$default_value=null);
    
    static function clear();
    
    static function is_set($path);

}

?>