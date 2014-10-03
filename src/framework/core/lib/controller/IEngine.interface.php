<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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