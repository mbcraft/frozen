<?php

$dir = new Dir("/immagini/grafica/layouts/simplesamplesite_interno/le_collezioni/");
$all_files = $dir->listFiles();
$selected = $all_files[rand(0,count($all_files)-1)];
set_sector("/immagine_sfondo",$selected->getPath());

$contenuto = call("testi","by_chiave",array("chiave" => "le_collezioni"));

Html::set_title("Le collezioni - SimpleSampleSite");

Html::set_layout("simplesamplesite_interno");

include("include/layouts/page_common.php.inc");

start_sector("/contenuto");
echo $contenuto["testo"];
end_sector();

start_sector("/main_menu");
MenuBuilder::build("main","/contenuti/it/");
end_sector();

start_sector("/citazione/testo");
?>
It is hard to say how much time a customer will take to respond to an email. Sometimes dragons start popping outside, or meteor start falling nearby ... who knows? Everything can happen.
<?
end_sector();
set_sector("/citazione/firma","DevelDevelDevel Guy");


?>
