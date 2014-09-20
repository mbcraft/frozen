<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$id_gallery_image = $_GET["id_gallery_image"];

start_admin_panel("/pannello_centrale","Modifica immagine");

$gallery_image = call("gallery_image","get_image",array("id_gallery_image" => $id_gallery_image));

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

var_dump($gallery_image);
?>

<form name="form__carica_immagine_gallery" action="/actions/gallery_image/modify_image.php" method="post">
    <?
    include_block("gallery/images/__form_modifica_immagini",$gallery_image);
    ?>
    <br />
    <?
    include_block("gallery/gallery/link_to_gallery",array("id_gallery" => $gallery_image["id_gallery"]));
    ?>
    <button type="submit">
        <span>Salva</span>
    </button>

    <? Form::on_success("/admin/gallery/index_gallery.php?id_gallery=".$gallery_image["id_gallery"]) ?>
    <? Form::on_failure("/admin/gallery/modifica_immagine.php?id_gallery_image=".$id_gallery_image) ?>

</form>
<?
end_admin_panel();
?>