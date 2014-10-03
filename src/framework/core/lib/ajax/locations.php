<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


    require_once("../../lib/fg.php");

    require_once("lib/forms/locations.php");
    require_once("lib/session/utils.php");

    fg_page_start(true);
    //1 : verificare il tipo di tabella su cui effettuare la ricerca
    //stato,regione,provincia

    //2 : utilizzando il/i codice/i forniti effettuare le query

    //3 : restituire i dati formattati pronti per la sostituzione del dom

    //OK FUNZIONA

    //if (fg_openxd_is_doing_subscription() || fg_is_logged_in())
    {
        $id_stato = isset($_REQUEST['id_stato']) ? $_REQUEST['id_stato'] : 0;
        $id_regione = isset($_REQUEST['id_regione']) ? $_REQUEST['id_regione'] : 0;
        $id_provincia = isset($_REQUEST['id_provincia']) ? $_REQUEST['id_provincia'] : 0;
        $id_comune = isset($_REQUEST['codice_istat_comune']) ? $_REQUEST['codice_istat_comune'] : 0;

        if ($_REQUEST['tipo']=="stati")
            fg_write_stato($id_stato);

        if ($_REQUEST['tipo']=="regioni")
             fg_write_regione($id_stato, $id_regione);

        if ($_REQUEST['tipo']=="province")
            fg_write_provincia($id_regione,$id_provincia);

        if ($_REQUEST['tipo']=="comuni")
            fg_write_comune($id_provincia,$id_comune);
    }
    /*
    else
    {
        fg_log_intrusion_blocked();
        fg_write_intrusion_blocked();
    }
    */
    fg_page_end();
?>