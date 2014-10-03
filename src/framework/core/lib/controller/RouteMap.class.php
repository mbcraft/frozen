<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * DA TENER PRESENTE PER FUTURE EVOLUZIONI DEL FRAMEWORK
 *
 * HTTP_HOST : phptesting.frostlab.it
 * SCRIPT_URL : /chi_siamo.php/adesso/cosa/fai
 * SCRIPT_URI : http://phptesting.frostlab.it/chi_siamo.php/adesso/cosa/farai
 * REQUEST_URI : /chi_siamo.php/adesso/cosa/farai?dimmi=un&po=tu
 *
 *
 * //echo "SCRIPT_URL : ".$_SERVER["SCRIPT_URL"]."<br />";
 * //echo "SCRIPT_URI : ".$_SERVER["SCRIPT_URI"]."<br/>";
 * //echo "REQUEST_URI : ".$_SERVER["REQUEST_URI"];
 *
 */

/*
 * ESEMPIO :
 *
 * /admin/session.php/login
 * /admin/session.php/logout
 * /admin/prodotti/modifica.php
 * /admin/prodotti/elimina.php
 * /admin/prodotti/nuovo.php
 *
 */

/*
 *
 * Compito di questa classe :
 * 1) leggere il file con le configurazioni di routing -> fatto dalla parte di __ConfigAutoloader
 * 2) determinare per una richiesta chi sono : controller, action e params
 * 3) invocare il controller
 *
 */
class RouteMap
{
    private static $route_definitions=array();

    private static function sanitize_environment()
    {
        if (get_magic_quotes_gpc())
        {
            global $_GET;
            global $_POST;
            if (isset($_GET))
            {
                foreach($_GET as $key=>$value)
                {
                    $_GET[$key] = stripslashes($value);
                }
            }
            if (isset($_POST))
            {
                foreach($_POST as $key=>$value)
                {
                    $_POST[$key] = stripslashes($value);
                }
            }
        }
    }

    public static function init()
    {
        self::sanitize_environment();
    }
    
    public static function def($definition,$controller_def=null,$action_def=null,$format_def=null)
    {
        $route_def = new RouteDefinition($definition, true,$controller_def,$action_def,$format_def);
        self::$route_definitions[] = $route_def;
    }
    
    public static function print_definitions_as_html_list()
    {
        echo "<h3>Routing definitions :</h3><br/>";
        echo "<ul>";
        foreach (self::$route_definitions as $def)
        {
            echo "<li>";
            $def->dump();
            echo "</li>";

        }
        echo "</ul>";
    }
    
    public static function dispatch()
    {
        $route_matched = false;

        $request_uri = Engines::getRequestUri();
        
        foreach (self::$route_definitions as $def)
        {
            if ($def->matches($request_uri))
            {
                $route_matched = true;

                $match = $def->getMatch($request_uri);
                
                $controller_name = $match->getController();
                $action_name = $match->getAction();
                $format_name = $match->getFormat();

                CallStack::call($controller_name,$action_name,$format_name,array());
            }

        }

        if (!$route_matched)
        {
            foreach (self::$route_definitions as $route_def)
            {
                echo $route_def->dump();
            }
            Log::error("dispatch","Mapping not found for URL : ".Engines::getRequestUri());
        }

    }
}



?>