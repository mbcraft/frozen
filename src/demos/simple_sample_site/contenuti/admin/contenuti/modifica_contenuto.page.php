<?php

Html::set_title("Pannello di amministrazione - Modifica contenuto");
if (call("admin","is_logged"))
Html::set_layout("admin");
else
{
    Html::set_layout("admin_forbidden");
    return;
}


$contenuto = call("contenuti","get");

start_sector("/pannello_centrale");
?>

<form action="/actions/contenuti/modify.php" method="POST">

<?php

    include_block ("contenuti/form_modifica_testi",$contenuto);
?>
    <br />
    <a href="/admin/contenuti/index.php">Torna all'elenco dei contenuti</a>
    <input type="submit" name="Salva modifiche" value="Salva modifiche" />
    <? Form::on_success("/admin/contenuti/"); ?>
</form>
<?
end_sector();

start_sector("/bottom");
?>
<center>
Powered by MBCRAFT
</center>
<?
end_sector();
?>
