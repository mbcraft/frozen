<?php

preload("AdminController");

admin_page("Gestione contenuti");

$testo = call("testi","new_empty");

start_admin_panel("/pannello_centrale","Crea nuovo contenuto");

include_block ("contenuti/testi/form_modifica_testi",
                   array("testo" => $testo, "submit_button_text" => "Crea","action" => "/actions/testi/create.php"
                   , "form_name" => "form_crea_testi"));

end_admin_panel();

?>