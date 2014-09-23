<?php

preload("AdminController");

admin_page("Gestione contenuti");

$immagine = call("immagini","get");

start_admin_panel("/pannello_centrale","Modifica immagine : ".$immagine["nome"]);
?>

<form name="form_modifica_immagine" enctype="multipart/form-data" action="/actions/immagini/modify.php" method="POST">

<?php

    include_block ("media/immagini/form_modifica_immagini",$immagine);
?>
    <br />
    <br />
    <a href="/admin/media/immagini/?folder=<?=$immagine["folder"] ?>">Annulla, torna all'elenco delle immagini</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/media/immagini/?folder=".$immagine["folder"]); ?>
    <? Form::on_failure("/admin/media/immagini/modifica_immagine.php"); ?>
</form>
<?
end_admin_panel();

?>