<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Carica documento");

$documento = call("documenti","new_empty");

start_admin_panel("/pannello_centrale","Carica documento");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuovo_documento" enctype="multipart/form-data" action="/actions/documenti/create.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
<?php
include_block ("contenuti/documenti/form_modifica_documenti",$documento);
?>

    <br />
    <br />
    <a href="/admin/contenuti/documenti/">Annulla, torna all'elenco dei documenti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/contenuti/documenti/") ?>
    <? Form::on_failure("/admin/contenuti/documenti/nuovo_documento.php") ?>
    
</form>
<?
end_admin_panel();

?>