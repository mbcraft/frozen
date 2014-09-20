<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

$id_gallery_collection = $_GET["id_gallery_collection"];

admin_page("Pannello di amministrazione - Gestione gallery");

start_admin_panel("/pannello_centrale","Modifica raccolta");

$collection = call("gallery_collection","get_collection",array("id_gallery_collection"=> $id_gallery_collection));

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_modifica_collection" action="/actions/gallery_collection/modify_collection.php" method="post">
    <?
    include_block("gallery/collection/__form_modifica_collection",$collection);
    ?>
    <br />
    <br />
    <? include_block("gallery/link_to_root"); ?>
    <button type="submit">
        <span>Salva</span>
    </button>

    <? Form::on_success("/admin/gallery/") ?>
    <? Form::on_failure("/admin/gallery/modifica_collection.php?id_gallery_collection=".$id_gallery_collection) ?>

</form>
<?
end_admin_panel();
?>