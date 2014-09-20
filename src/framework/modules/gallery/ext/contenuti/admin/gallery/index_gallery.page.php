<?php

//INIZIO VARIABILI
preload("AdminController");

$id_gallery = $_GET["id_gallery"];

admin_page("Pannello di amministrazione - Gestione immagini gallery");

$result = call("gallery","get_gallery",array("id_gallery" => $id_gallery));

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();


start_admin_panel("/pannello_centrale","Gestione Gallery : ".htmlentities($result["title"]));

include_block("gallery/collection/link_to_collection",array("id_gallery_collection" => $result["id_gallery_collection"]));
include_block("gallery/images/link_nuova_immagine",array("id_gallery" => $id_gallery));

include_block_if("gallery/images/elenco_immagini","gallery/images/nessuna_immagine",count($result["image_list"])>0,$result);

include_block("gallery/images/link_nuova_immagine",array("id_gallery" => $id_gallery));

end_admin_panel();
?>