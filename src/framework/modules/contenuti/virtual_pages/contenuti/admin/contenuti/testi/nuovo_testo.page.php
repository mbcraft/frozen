<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Modifica contenuto");

$testo = call("testi","new_empty");

start_admin_panel("/pannello_centrale","Crea nuovo contenuto");
?>

<form action="/actions/testi/create.php" method="POST">
    <input type="hidden" name="id_folder" value="<?=Session::get("/admin/current_folder/id") ?>" />
<?php
include_block ("contenuti/testi/form_modifica_testi",$testo);
?>

    <br />
    <br />
    <a href="/admin/testi/index.php">Annulla, torna all'elenco dei contenuti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/contenuti/testi/") ?>
</form>
<?
end_admin_panel();

?>