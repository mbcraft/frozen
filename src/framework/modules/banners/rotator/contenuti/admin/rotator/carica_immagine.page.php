<?php

$rotator_name = $_GET["rotator_name"];

preload("AdminController");
admin_page("Gestione rotator : ".Params::get("rotator_name"));


start_admin_panel("/pannello_centrale","Carica immagine rotator");

?>
<form name="form__carica_immagine_rotator" enctype="multipart/form-data" method="POST" action="/actions/rotator/add_rotator_image.php">
    <input type="hidden" name="rotator_name" value="<?=$rotator_name ?>" />
    Immagine rotator : <input type="file" name="my_file" /><br />
    <br />
    <br />
    <a href="#" onclick="history.back(-1);">Annulla, torna alle immagini del rotator</a>&nbsp;&nbsp;
    <button type="submit">
        <div>
            Carica immagine
        </div>
    </button>
    <?
        Form::after("/admin/rotator/modifica_rotator.php?rotator_name=".$rotator_name);
    ?>
</form>
<?
end_admin_panel();
?>