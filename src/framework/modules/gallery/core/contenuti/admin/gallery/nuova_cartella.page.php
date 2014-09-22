<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

if (isset(Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION)
{
start_admin_panel("/pannello_centrale","Crea nuova cartella");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuova_gallery" action="/actions/gallery/create_folder.php" method="post">

    Nome della cartella : <input type="text" name="folder_name" value="" />

    <br />
    <br />
    <a href="/admin/gallery/">Annulla, torna alla gestione gallery</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/gallery/") ?>
    <? Form::on_failure("/admin/gallery/nuova_cartella.php") ?>

</form>
<?php
end_admin_panel();
}
?>