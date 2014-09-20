<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$id_gallery = $_GET["id_gallery"];

start_admin_panel("/pannello_centrale","Carica immagine");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form__carica_immagine_gallery" enctype="multipart/form-data" action="/actions/gallery_image/add_to_gallery.php" method="post">
    <?
    include_block("gallery/images/__form_modifica_immagini",array("id_gallery" => $id_gallery));
    ?>
    <br />
    <? include_block("gallery/gallery/link_to_gallery",array("id_gallery" =>$id_gallery)); ?>
    <button type="submit">
        <span>Carica</span>
    </button>

    <? Form::on_success("/admin/gallery/index_gallery.php?id_gallery=".$id_gallery) ?>
    <? Form::on_failure("/admin/gallery/nuova_immagine.php?id_gallery=".$id_gallery) ?>

</form>
<?
end_admin_panel();

?>