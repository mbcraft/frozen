<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Modifica documento");

$documento = call("documenti","get");

start_admin_panel("/pannello_centrale","Modifica documento");
?>

<form name="form_modifica_documento" enctype="multipart/form-data"  action="/actions/documenti/modify.php" method="POST">

<?php

    include_block ("contenuti/documenti/form_modifica_documenti",$documento);
?>
    <br />
    <br />
    <a href="/admin/contenuti/documenti/">Annulla, torna all'elenco dei documenti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/contenuti/documenti/"); ?>
    <? Form::on_failure("/admin/contenuti/documenti/modifica_documento.php"); ?>
</form>
<?
end_admin_panel();

?>