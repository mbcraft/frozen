<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class ApplicationController extends AbstractController
{
    function version()
    {
        $f = new File("/application.ini");

        $props = PropertiesUtils::readFromFile($f,false);

        return $props["version"];
    }

    function application_name()
    {
        $f = new File("/application.ini");

        $props = PropertiesUtils::readFromFile($f,false);

        return $props["name"];
    }
}

?>