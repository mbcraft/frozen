<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

start_admin_panel("/pannello_centrale","Crea nuova gallery");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form_nuova_gallery" action="/actions/gallery/create_gallery.php" method="post">

    Nome della gallery : <input type="text" name="gallery_name" value="" />

    <br />
    <br />
    <a href="/admin/gallery/">Annulla, torna alla gestione gallery</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Crea</span>
    </button>

    <? Form::on_success("/admin/gallery/") ?>
    <? Form::on_failure("/admin/gallery/nuova_gallery.php") ?>

</form>
<?
end_admin_panel();

?>