<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Modifica immagine");

$immagine = call("immagini","get");

start_admin_panel("/pannello_centrale","Modifica immagine");
?>

<form name="form_modifica_immagine" enctype="multipart/form-data" action="/actions/immagini/modify.php" method="POST">

<?php

    include_block ("contenuti/immagini/form_modifica_immagini",$immagine);
?>
    <br />
    <br />
    <a href="/admin/contenuti/immagini/">Annulla, torna all'elenco delle immagini</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/contenuti/immagini/"); ?>
    <? Form::on_failure("/admin/contenuti/immagini/modifica_immagine.php"); ?>
</form>
<?
end_admin_panel();

?>