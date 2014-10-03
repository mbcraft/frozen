<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa classe contiene i dati che hanno fatto match per il routing di una richiesta.
 */
class RouteMatch extends BasicObject
{
    private $controller;
    private $action;
    private $format;

    function __construct($controller,$action,$format)
    {
        if ($controller==null || $action==null || $format==null) Log::error("__constuct","Errore nei parametri del costruttore di __RouteMatch");

        $this->controller = $controller;
        $this->action = $action;
        $this->format = $format;
    }

    function getController()
    {
        return $this->controller;
    }

    function getAction()
    {
        return $this->action;
    }

    function getFormat()
    {
        return $this->format;
    }

}

?>