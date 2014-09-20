<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Modifica immagine");

$immagine = call("immagini","new_empty");

start_admin_panel("/pannello_centrale","Crea nuovo contenuto");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuova_immagine" enctype="multipart/form-data" action="/actions/immagini/create.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
<?php
include_block ("contenuti/immagini/form_modifica_immagini",$immagine);
?>

    <br />
    <br />
    <a href="/admin/contenuti/immagini/">Annulla, torna all'elenco delle immagini</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/contenuti/immagini/") ?>
    <? Form::on_failure("/admin/contenuti/immagini/nuova_immagine.php") ?>
</form>
<?
end_admin_panel();

?>