<?php
preload("AdminController");
admin_page("Gestione rotator");

$elenco_rotator = call("rotator","get_available_rotators");

start_admin_panel("/pannello_centrale","Elenco rotator");

$params = array();

$params["elenco_rotator"] = $elenco_rotator;

?>
<div class="azioni">
</div>
<?
include_block_if("banners/rotator/elenco_rotator","banners/rotator/nessun_rotator",count($elenco_rotator)>0,$params);
?>
<div class="azioni">
</div>
<?
end_admin_panel();
?>