<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Engines
{
    private static $engines = array();

    public static function getRequestUri()
    {
        if (isset($_SERVER["REQUEST_URI"]))
            return $_SERVER["REQUEST_URI"];
        else
            return $_SERVER["SCRIPT_NAME"];
    }

    public static function getInstance()
    {
        if (self::$instance==null) self::$instance = new Engines();
    }

    public static function registerEngine($engine_class_name)
    {
        self::$engines[] = __create_instance($engine_class_name);
    }

    public static function executeRequest()
    {
        if (count(self::$engines)==0)
        {
            echo "<h2>Nessun engine configurato.</h2>";
            return;
        }
        foreach (self::$engines as $engine)
        {
            if ($engine->acceptRequest())
            {
                $engine->executeRequest();
                return;
            }
        }
    }
}

?>