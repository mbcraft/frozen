<?php


preload("AdminController");

admin_page("Gestione documenti - indice");

$path = Params::get("path");
preg_match("/\//",$path,$matches);
$level = count($matches)-1;

$elenco_cartelle = call("folders","index",
                        array(
                             "__filter_tipo__EQUAL" => "f_documenti" ,
                             "__filter_path__BEGINS_WITH" => $folder_path,
                             "__filter_level__EQUAL" => $level,
                             "__filter_ordine__ORDER_ASCENDING" => null));

start_admin_panel("/pannello_centrale","Gestione Documenti");

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();

include("include/snippets/contenuti/base/__elenco_cartelle.php.inc");
include("include/snippets/contenuti/base/__elenco_documenti.php.inc");

end_admin_panel();
?>