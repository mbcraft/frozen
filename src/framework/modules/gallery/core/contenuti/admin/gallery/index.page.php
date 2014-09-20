<?php

//INIZIO VARIABILI
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$result = call("gallery","index");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();


start_admin_panel("/pannello_centrale","Gestione Gallery");
if (isset(Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION)
    include_block("gallery/link_nuova_cartella");
include_block("gallery/link_nuova_gallery");

include_block_if("gallery/elenco_elementi","gallery/nessun_elemento",count($result["elements"])>0,$result);

if (isset(Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION) && Config::instance()->GALLERY_ADMIN__ENABLE_FOLDER_ADMINISTRATION)
    include_block("gallery/link_nuova_cartella");
include_block("gallery/link_nuova_gallery");

end_admin_panel();
?>