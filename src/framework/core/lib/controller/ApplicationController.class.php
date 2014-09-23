<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

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