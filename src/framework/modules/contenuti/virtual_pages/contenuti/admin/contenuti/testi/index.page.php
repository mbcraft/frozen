<?php

preload("AdminController");

admin_page("Gestione testi - indice");

$folder_id = Session::get("/admin/current_folder/id");

$testi = call("testi","index",array("__filter_id_folder__EQUALS" =>  $folder_id));

start_admin_panel("/pannello_centrale","Elenco contenuti");

$params = array();
$params["elenco_cartelle"] = $cartelle;
$params["elenco_testi"] = $testi;

?>
    <div class="azioni">
        <a href="/admin/contenuti/testi/nuovo_testo.php">Crea nuovo contenuto</a>
    </div>
<?

include_block_if("contenuti/testi/elenco_testi","contenuti/testi/nessun_testo",count($testi)>0,$params);

?>
    <div class="azioni">
        <a href="/admin/contenuti/testi/nuovo_testo.php">Crea nuovo contenuto</a>
    </div>
<?
end_admin_panel();
?>