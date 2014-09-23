<?php

preload("AdminController");
admin_page("Gestione gruppi banner");


$gruppi_banner = call("sponsor_banner","index_banner_group");

start_admin_panel("/pannello_centrale","Elenco gruppi banner");

$params = array();

$params["elenco_gruppi_banner"] = $gruppi_banner;

include_block("banners/sponsor/link_nuovo_gruppo_banner");

include_block_if("banners/sponsor/table/elenco_gruppi_banner","banners/sponsor/table/nessun_gruppo_banner",count($gruppi_banner)>0,$params);

include_block("banners/sponsor/link_nuovo_gruppo_banner");

end_admin_panel();
?>