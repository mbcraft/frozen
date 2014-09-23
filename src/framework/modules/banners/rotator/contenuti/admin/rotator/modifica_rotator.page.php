<?php

$rotator_name = $_GET["rotator_name"];

preload("AdminController");
admin_page("Gestione rotator");


$image_list = call("rotator","get_rotator_images",array("rotator_name" => $rotator_name));

$params = array("rotator_name" => $rotator_name,"image_list" => $image_list);

start_admin_panel("/pannello_centrale","Modifica rotator - ".$rotator_name);

?>
<div class="azioni">
    <a href="/admin/rotator/carica_immagine.php?rotator_name=<?=$rotator_name ?>">Carica nuova immagine</a>
</div>
<?
include_block_if("banners/rotator/elenco_immagini","banners/rotator/nessuna_immagine",count($image_list)>0,$params);
?>
<div class="azioni">
    <a href="/admin/rotator/carica_immagine.php?rotator_name=<?=$rotator_name ?>">Carica nuova immagine</a>
</div>
<?
end_admin_panel();
?>