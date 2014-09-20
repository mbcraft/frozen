<?php

preload("AdminController");

admin_page("Gestione contenuti");

$documento = call("documenti","new_empty");

start_admin_panel("/pannello_centrale","Carica nuovo documento");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuovo_documento" enctype="multipart/form-data" action="/actions/documenti/add.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
<?php
$documento = call("documenti","new_empty");
if (isset($_GET["folder"]))
$documento["folder"] = $_GET["folder"];
include_block ("media/documenti/form_modifica_documento",$documento);
?>

    <br />
    <br />
    <a href="/admin/media/documenti/?folder=<?=$_GET["folder"] ?>">Annulla, torna all'elenco dei documenti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Carica documento</span>
    </button>

    <? Form::on_success("/admin/media/documenti/?folder=".$_GET["folder"]) ?>
    <? Form::on_failure("/admin/media/documenti/nuovo_documento.php?folder=".$_GET["folder"]) ?>
</form>
<?
end_admin_panel();

?>