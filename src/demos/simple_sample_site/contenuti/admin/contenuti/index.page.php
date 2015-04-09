<?php

Html::set_title("Pannello di amministrazione - Visualizza contenuti");
if (call("admin","is_logged"))
Html::set_layout("admin");
else
{
    Html::set_layout("admin_forbidden");
    return;
}

$elenco_contenuti = call("contenuti","index");

start_sector("/pannello_centrale");

$params = array();
$params["elenco_contenuti"] = $elenco_contenuti;

include_block_if("contenuti/elenco_contenuti","contenuti/nessun_contenuto",count($elenco_contenuti)>0,$params);

?>

    <br />
    <a href="/admin/contenuti/nuovo_contenuto.php">Crea nuovo contenuto</a>

<?
end_sector();



start_sector("/bottom");
?>
<center>
Powered by MBCRAFT
</center>
<?
end_sector();
?>
