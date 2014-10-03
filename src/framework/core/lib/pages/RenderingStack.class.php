<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class RenderingStack
{
    private static $stack = array();
    
    public static function clear()
    {
        self::$stack = array();
    }
    
    private static function init()
    {
        if (empty(self::$stack))
            array_push(self::$stack,PageData::instance()->view("/"));
    }
    
    public static function peek()
    {
        self::init();
        return self::$stack[count(self::$stack)-1];
    }
    
    public static function push($view)
    {
        self::init();
        array_push(self::$stack,$view);
    }
    
    public static function pop()
    {
        self::init();
        array_pop(self::$stack);
    }
}

?>