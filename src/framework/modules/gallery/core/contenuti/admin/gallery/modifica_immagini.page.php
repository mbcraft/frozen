<?php

//INIZIO VARIABILI
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

$gallery = call("gallery","get_current_gallery");
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();


start_admin_panel("/pannello_centrale","Modifica immagini gallery : ".$gallery["gallery_name"]);



include_block("gallery/link_nuova_immagine");
include_block("gallery/link_to_parent_folder");
include_block_if("gallery/elenco_immagini","gallery/nessuna_immagine",count($gallery["image_list"])>0,$gallery);

include_block("gallery/link_nuova_immagine");

end_admin_panel();
?>