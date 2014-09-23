<?php

preload("AdminController");


admin_page("Gestione contenuti");

start_admin_panel("/pannello_centrale","Elenco documenti");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

/*
 * Utilizzo dell'id folder per determinare la cartella corrente.
 * */
$params = array();

if (isset($_GET["folder"]))
    $params["__filter_folder__EQUAL"] = $_GET["folder"];

$documenti = call("documenti","index",$params);

$params2 = array();
$params2["elenco_documenti"] = $documenti;

$show_aggiungi_documenti = isset(Config::instance()->GESTIONE_CONTENUTI__DOCUMENT_LIMIT) && Config::instance()->GESTIONE_CONTENUTI__DOCUMENT_LIMIT>count($documenti);

if ($show_aggiungi_documenti)
    include_block("media/documenti/link_nuovo_documento");

include_block_if("media/documenti/elenco_documenti","media/documenti/nessun_documento",count($documenti)>0,$params2);

if ($show_aggiungi_documenti)
    include_block("media/documenti/link_nuovo_documento");

end_admin_panel();
?>