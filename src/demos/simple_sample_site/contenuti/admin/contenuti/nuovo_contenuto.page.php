<?php

Html::set_title("Pannello di amministrazione - Modifica contenuto");
if (call("admin","is_logged"))
Html::set_layout("admin");
else
{
    Html::set_layout("admin_forbidden");
    return;
}

$contenuto = call("contenuti","new_empty");

start_sector("/pannello_centrale");
?>

<form action="/actions/contenuti/create.php" method="POST">
<?php
include_block ("contenuti/form_modifica_testi",$contenuto);
?>

    <br />
    <a href="/admin/contenuti/index.php">Torna all'elenco dei contenuti</a>
    <input type="submit" name="Crea" value="Crea" />
    <? Form::on_success("/admin/contenuti/index.php") ?>
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
