<?php

$dir = new Dir("/immagini/grafica/layouts/simplesamplesite_interno/laboratorio/");
$all_files = $dir->listFiles();
$selected = $all_files[rand(0,count($all_files)-1)];
set_sector("/immagine_sfondo",$selected->getPath());

$contenuto = call("testi","by_chiave",array("chiave" => "laboratorio"));

Html::set_title("Laboratory - SimpleSampleSite");

Html::set_layout("simplesamplesite_laboratorio");

include("include/layouts/page_common.php.inc");

start_sector("/contenuto");
echo $contenuto["testo"];
end_sector();

start_sector("/main_menu");
MenuBuilder::build("main","/contenuti/it/");
end_sector();

start_sector("/vetrine/sinistra");
$vetrina_sx = call("vetrine","index",array("__filter_nome_vetrina__EQUAL" => "vetrina sinistra"));
$prodotti_vetrina_sx = call("vetrine","elenco_prodotti_servizi_vetrina",array("id_vetrina" => $vetrina_sx[0]["id_vetrina"]));
include_block("table/show_in_grid",array("rows" => 2,"cols" => 4,"elenco_oggetti" => $prodotti_vetrina_sx,"blocco_presentazione" => "simplesamplesite/prodotto_vetrina_small"));
end_sector();

start_sector("/vetrine/destra");
$vetrina_dx = call("vetrine","index",array("__filter_nome_vetrina__EQUAL" => "vetrina destra"));
$prodotti_vetrina_dx = call("vetrine","elenco_prodotti_servizi_vetrina",array("id_vetrina" => $vetrina_dx[0]["id_vetrina"]));
include_block("table/show_in_grid",array("rows" => 2,"cols" => 4,"elenco_oggetti" => $prodotti_vetrina_dx,"blocco_presentazione" => "simplesamplesite/prodotto_vetrina_small"));
end_sector();

?>