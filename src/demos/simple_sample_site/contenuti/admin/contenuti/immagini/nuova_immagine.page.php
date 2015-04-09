<?php

preload("AdminController");

admin_page("Gestione contenuti");

$immagine = call("immagini","new_empty");

start_admin_panel("/pannello_centrale","Carica nuova immagine");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuova_immagine" enctype="multipart/form-data" action="/actions/immagini/add.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
    <input type="hidden" name="id_folder" value="<?=Session::get("/admin/current_folder/id") ?>" />
<?php
include_block ("contenuti/immagini/form_modifica_immagini",$immagine);
?>

    <br />
    <br />
    <a href="/admin/contenuti/immagini/">Annulla, torna all'elenco delle immagini</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Carica immagine</span>
    </button>

    <? Form::on_success("/admin/contenuti/immagini/") ?>
    <? Form::on_failure("/admin/contenuti/immagini/nuova_immagine.php") ?>
</form>
<?
end_admin_panel();

?>