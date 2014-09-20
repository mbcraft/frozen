<?php

preload("AdminController");

admin_page("Gestione contenuti");

$documento = call("documenti","get");

start_admin_panel("/pannello_centrale","Modifica documenti : ".$documento["nome"]);
?>

<form name="form_modifica_documento" enctype="multipart/form-data" action="/actions/documenti/modify.php" method="POST">

<?php

    include_block ("media/documenti/form_modifica_documento",$documento);
?>
    <br />
    <br />
    <a href="/admin/media/documenti/?folder=<?=$documento["folder"] ?>">Annulla, torna all'elenco dei documenti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/media/documenti/?folder=".$documento["folder"]); ?>
    <? Form::on_failure("/admin/media/documenti/modifica_documento.php"); ?>
</form>
<?
end_admin_panel();

?>