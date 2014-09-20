<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * DA TENER PRESENTE PER FUTURE EVOLUZIONI DEL FRAMEWORK
 *
 * HTTP_HOST : phptesting.frostlab.it
 * SCRIPT_URI : http://phptesting.frostlab.it/chi_siamo.php/adesso/cosa/farai
 * REQUEST_URI : /chi_siamo.php/adesso/cosa/farai?dimmi=un&po=tu
 */

interface IEngine
{
    function acceptRequest();

    function executeRequest();
    

}

?>