<?php

//INIZIO VARIABILI
preload("AdminController");

$id_gallery_collection = $_GET["id_gallery_collection"];

admin_page("Pannello di amministrazione - Gestione gallery");

$result = call("gallery","index",array("id_gallery_collection" => $id_gallery_collection));

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();


start_admin_panel("/pannello_centrale","Gestione Raccolta : ".htmlentities($title));

include_block("gallery/link_to_root");
if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION)
{} else include_block("gallery/gallery/link_nuova_gallery",array("id_gallery_collection" => $id_gallery_collection));

include_block_if("gallery/gallery/elenco_gallery","gallery/gallery/nessuna_gallery",count($result)>0,array("gallery_list" => $result));

if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_GALLERY_ADMINISTRATION)
{} else include_block("gallery/gallery/link_nuova_gallery",array("id_gallery_collection" => $id_gallery_collection));

end_admin_panel();
?>