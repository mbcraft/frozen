<?php

//INIZIO VARIABILI
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione raccolte di gallery");

$result = call("gallery_collection","index");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

$result = call("gallery_collection","index");

start_admin_panel("/pannello_centrale","Elenco Raccolte");

if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_COLLECTION_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_FOLDER_ADMINISTRATION)
{} else include_block("gallery/collection/link_nuova_collection");

include_block_if("gallery/collection/elenco_collection","gallery/collection/nessuna_collection",count($result)>0,array("collection_list" => $result));

if (isset(Config::instance()->GALLERY_ADMIN__DISABLE_COLLECTION_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__DISABLE_FOLDER_ADMINISTRATION)
{} else include_block("gallery/collection/link_nuova_collection");

end_admin_panel();
?>