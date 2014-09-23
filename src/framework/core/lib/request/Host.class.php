<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Host
{
    static function current()
    {
        return $_SERVER["HTTP_HOST"];
    }

    static function current_no_www()
    {
        $current_host = self::current();
        if (strpos($current_host,"www.")===0)
            return substr($current_host,4);
        else
            return $current_host;
    }
    
    static function isRemote()
    {
        return !Host::isLocal();
    }
    
    static function isLocal()
    {
        $current_host = Host::current();
        if (strstr($current_host,".")===false)
            return true;
        else 
            return false;
    }
}

?>