<?php

preload("AdminController");

admin_page("Gestione contenuti");

$testo = call("testi","get");

start_admin_panel("/pannello_centrale","Modifica contenuto : ".$testo["titolo"]);

include_block ("contenuti/testi/form_modifica_testi",
                   array("testo" => $testo, "submit_button_text" => "Salva modifiche","action" => "/actions/testi/modify.php",
                   "form_name" => "form_modifica_testi"));

end_admin_panel();

?>