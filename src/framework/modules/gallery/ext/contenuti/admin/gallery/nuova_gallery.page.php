<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

$id_gallery_collection = $_GET["id_gallery_collection"];

admin_page("Pannello di amministrazione - Gestione gallery");

if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION)
{} else {
start_admin_panel("/pannello_centrale","Crea nuova gallery");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();


?>
<form name="form_nuova_gallery" action="/actions/gallery/create_gallery.php" method="post">

    <?
    include_block("gallery/gallery/__form_modifica_gallery",array("id_gallery_collection" => $id_gallery_collection));
    ?>

    <br />
    <br />
    <? include_block("gallery/collection/link_to_collection",array("id_gallery_collection" => $id_gallery_collection)); ?>
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/gallery/index_collection.php?id_gallery_collection=".$id_gallery_collection) ?>
    <? Form::on_failure("/admin/gallery/nuova_gallery.php?id_gallery_collection=".$id_gallery_collection) ?>

</form>
<?
end_admin_panel();
}
?>