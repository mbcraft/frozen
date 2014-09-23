<?php

preload("AdminController");


admin_page("Gestione contenuti");

start_admin_panel("/pannello_centrale","Elenco immagini");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

/*
 * Utilizzo dell'id folder per determinare la cartella corrente.
 * */
$params = array();

if (isset($_GET["folder"]))
    $params["__filter_folder__EQUAL"] = $_GET["folder"];

$immagini = call("immagini","index",$params);

$params2 = array();
$params2["elenco_immagini"] = $immagini;

$show_aggiungi_immagine = isset(Config::instance()->GESTIONE_CONTENUTI__IMAGE_LIMIT) && Config::instance()->GESTIONE_CONTENUTI__IMAGE_LIMIT>count($immagini);

if ($show_aggiungi_immagine)
    include_block("media/immagini/link_nuova_immagine");

include_block_if("media/immagini/elenco_immagini","media/immagini/nessuna_immagine",count($immagini)>0,$params2);

if ($show_aggiungi_immagine)
    include_block("media/immagini/link_nuova_immagine");

end_admin_panel();
?>