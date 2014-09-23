<?php

preload("AdminController");
admin_page("Gestione contenuti");


$testi = call("testi","index");

start_admin_panel("/pannello_centrale","Elenco contenuti");

$params = array();

$params["elenco_testi"] = $testi;

?>
    <? /* <div><a href="/admin/contenuti/testi/importa_testi.php">Importa</a></div>
    <div><a href="/admin/contenuti/testi/esporta_testi.php">Esporta</a></div> */ ?>
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