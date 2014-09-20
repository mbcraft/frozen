<?php

$id_banner_group = $_GET["id_banner_group"];

preload("AdminController");
admin_page("Gestione gruppi banner");


$gruppo_banner = call("sponsor_banner","get_banner_group.php",array("id_banner_group" => $id_banner_group));

start_admin_panel("/pannello_centrale","Modifica gruppo banner");

include_block("banners/sponsor/table/form_modifica_banner_group",$gruppo_banner);
include_block("banners/sponsor/link/back_to_banner_group_list");
?>
 oppure <input type="submit" name="Modifica gruppo banner" value="Modifica gruppo banner" />
<?
end_admin_panel();
?>