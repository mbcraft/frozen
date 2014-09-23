<?php

preload("AdminController");
admin_page("Gestione gruppi banner");

$id_banner_group = $_GET["id_banner_group"];

$elenco_banner = call("sponsor_banner","index_banner",array("__filter_id_banner_group__EQUAL" => $id_banner_group));

start_admin_panel("/pannello_centrale","Elenco banner");

$params = array();

$params["elenco_banner"] = $elenco_banner;

include_block("banners/sponsor/link_nuovo_banner");

include_block_if("banners/sponsor/table/elenco_banner","banners/sponsor/table/nessun_banner",count($elenco_banner)>0,$params);

include_block("banners/sponsor/link_nuovo_banner");

end_admin_panel();
?>