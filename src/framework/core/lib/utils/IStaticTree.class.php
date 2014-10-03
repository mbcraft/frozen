<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

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