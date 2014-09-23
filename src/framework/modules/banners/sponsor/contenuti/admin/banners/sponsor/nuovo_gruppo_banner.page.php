<?php

preload("AdminController");

admin_page("Gestione banner");

$banner_group = call("sponsor_banner","new_empty_banner_group");

start_admin_panel("/pannello_centrale","Crea nuovo gruppo banner");
?>
<form name="form__nuovo_gruppo_banner" method="post" action="/actions/sponsor_banner/new_banner_group.php">
<?
include_block ("banners/sponsor/table/form_modifica_banner_group",$banner_group);

include_block("banners/sponsor/link/back_to_banner_group_list");
?>
 oppure <input type="submit" name="Crea gruppo banner" value="Crea gruppo banner" />
<?
Form::on_success("/admin/banners/sponsor/index.php");
?>
</form>
<?
end_admin_panel();

?>