<?php

preload("AdminController");


admin_page("Gestione contenuti");

$folder_id = Session::get("/admin/current_folder/id");

start_admin_panel("/pannello_centrale","Elenco immagini");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

include("include/snippets/contenuti/base/__elenco_immagini.php.inc");

end_admin_panel();
?>