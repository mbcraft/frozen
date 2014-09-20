<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Modifica contenuto");

$testo = call("testi","get");

start_admin_panel("/pannello_centrale","Modifica contenuto");
?>

<form action="/actions/testi/modify.php" method="POST">

<?php

    include_block ("contenuti/testi/form_modifica_testi",$testo);
?>
    <br />
    <br />
    <a href="/admin/contenuti/testi/">Annulla, torna all'elenco dei contenuti</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Salva modifiche</span>
    </button>

    <? Form::on_success("/admin/contenuti/testi/"); ?>
</form>
<?
end_admin_panel();

?>