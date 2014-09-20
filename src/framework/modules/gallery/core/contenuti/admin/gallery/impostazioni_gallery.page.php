<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$gallery = call("gallery","get");

start_admin_panel("/pannello_centrale","Modifica gallery");
?>

<form name="form_modifica_gallery" action="/actions/gallery/modify.php" method="POST">

<?php

    include_block ("gallery/form_modifica_gallery",$gallery);
?>
    <br />
    <br />
    <a href="/admin/gallery/">Annulla, torna all'elenco delle gallery</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/gallery/"); ?>
    <? Form::on_failure("/admin/gallery/modifica_gallery.php"); ?>
</form>
<?
end_admin_panel();

?>