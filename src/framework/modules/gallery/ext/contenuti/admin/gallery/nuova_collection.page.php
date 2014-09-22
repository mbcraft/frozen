<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_COLLECTION_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_COLLECTION_ADMINISTRATION)
{} else {
start_admin_panel("/pannello_centrale","Crea nuova raccolta");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuova_gallery" action="/actions/gallery_collection/create_collection.php" method="post">

    <?
    include_block("gallery/collection/__form_modifica_collection");
    ?>

    <br />
    <br />
    <?
    include_block("gallery/link_to_root");
    ?>
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/gallery/") ?>
    <? Form::on_failure("/admin/gallery/nuova_collection.php") ?>

</form>
<?php
end_admin_panel();
}
?>