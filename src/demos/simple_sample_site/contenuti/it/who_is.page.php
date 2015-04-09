<?php

$dir = new Dir("/immagini/grafica/layouts/simplesamplesite_interno/chi_sono/");
$all_files = $dir->listFiles();
$selected = $all_files[rand(0,count($all_files)-1)];
set_sector("/immagine_sfondo",$selected->getPath());


$contenuto = call("testi","by_chiave",array("chiave" => "chi_sono"));

Html::set_title("Who is - SimpleSampleSite");

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
It is not simple to develop software, but if you try and put all your efforts in it, you surely will succeed. Probably the bits will try to escape from your files, but the hard disk will keep them there.
<?
end_sector();
set_sector("/citazione/firma","DevelDevelDevel Guy");


?>
