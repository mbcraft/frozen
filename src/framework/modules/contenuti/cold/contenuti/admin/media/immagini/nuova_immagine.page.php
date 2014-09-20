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
<?php
$immagine = array();
if (isset($_GET["folder"]))
$immagine["folder"] = $_GET["folder"];
include_block ("media/immagini/form_modifica_immagini",$immagine);
?>

    <br />
    <br />
    <a href="/admin/media/immagini/?folder=<?=$_GET["folder"] ?>">Annulla, torna all'elenco delle immagini</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Carica immagine</span>
    </button>

    <? Form::on_success("/admin/media/immagini/?folder=".$_GET["folder"]) ?>
    <? Form::on_failure("/admin/media/immagini/nuova_immagine.php?folder=".$_GET["folder"]) ?>
</form>
<?
end_admin_panel();

?>