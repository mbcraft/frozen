<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Cookie extends BasicObject
{
    const DEFAULT_PATH = "/";

    public static function set($key,$value)
    {
        $expire_time = time()+60*60*24*30;
        setcookie($key, $value, $expire_time , self::DEFAULT_PATH);
    }

    public static function get($key)
    {
        return $_COOKIE[$key];
    }

    public static function delete($key)
    {
        self::set($key, false);
    }


    public static function dump()
    {
        foreach (array_keys($_COOKIE) as $key)
        {
            echo "<!-- COOKIE : $key = ".$_COOKIE[$key]." -->";
        }
    }
}

?>