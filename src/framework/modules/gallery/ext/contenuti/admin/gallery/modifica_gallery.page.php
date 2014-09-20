<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$id_gallery = $_GET["id_gallery"];

start_admin_panel("/pannello_centrale","Modifica gallery");

$gallery = call("gallery","get_gallery",array("id_gallery"=> $id_gallery));

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_modifica_gallery" action="/actions/gallery/modify_gallery.php" method="post">
    <?
    include_block("gallery/gallery/__form_modifica_gallery",$gallery);
    ?>
    <br />
    <br />
    <?
    include_block("gallery/collection/link_to_collection",array("id_gallery_collection" => $gallery["id_gallery_collection"]));
    ?>
    <button type="submit">
        <span>Salva</span>
    </button>
    
    <? Form::on_success("/admin/gallery/index_collection.php?id_gallery_collection=".$gallery["id_gallery_collection"]) ?>
    <? Form::on_failure("/admin/gallery/modifica_gallery.php?id_gallery=".$id_gallery) ?>

</form>
<?
end_admin_panel();
?>