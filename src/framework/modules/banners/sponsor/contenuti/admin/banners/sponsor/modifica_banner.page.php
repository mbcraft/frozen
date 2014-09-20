<?php

preload("AdminController");
admin_page("Gestione gruppi banner");

$id_banner_group = $_GET["id_banner_group"];
$id_banner = $_GET["id_banner"];

$banner = call("sponsor_banner","get_banner",array("id_banner" => $id_banner));

start_admin_panel("/pannello_centrale","Modifica banner");
Flash::write_all_messages();
?>
<form name="form__crea_banner" enctype="multipart/form-data" method="post" action="/actions/sponsor_banner/save_banner.php" >
    <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
    
<?
include_block ("banners/sponsor/table/form_modifica_banner",$banner);

include_block("banners/sponsor/link/back_to_banner_list",array("id_banner_group" => $id_banner_group));

Form::on_success("/admin/banners/sponsor/index_banner.php?id_banner_group=".$id_banner_group);
Form::on_failure("/admin/banners/sponsor/modifica_banner.php?id_banner=".$id_banner);
?>
 oppure <input type="submit" name="Modifica banner" value="Modifica banner" />
</form>
<?
end_admin_panel();
?>