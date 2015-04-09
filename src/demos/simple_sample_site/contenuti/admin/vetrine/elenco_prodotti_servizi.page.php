<?

preload("AdminController");
admin_page("Gestione vetrine");

$elenco_prodotti_servizi_vetrina = call("vetrine","elenco_prodotti_servizi_vetrina",array("id_vetrina" => $_GET["id_vetrina"]));

start_admin_panel("/pannello_centrale","Elenco prodotti/servizi in vetrina");

include_block("vetrine/link_back_to_vetrine");
?>
<div class="azioni">
    <a href="/admin/vetrine/aggiungi_prodotto_servizio.php?id_vetrina=<?=$_GET["id_vetrina"] ?>">Aggiungi un prodotto/servizio alla vetrina</a>
</div>
<?
include_block_if("vetrine/prodotti_servizi/elenco_prodotti_servizi_vetrina","vetrine/prodotti_servizi/nessun_prodotto_servizio_vetrina",count($elenco_prodotti_servizi_vetrina)>0,array("elenco_prodotti_servizi_vetrina" => $elenco_prodotti_servizi_vetrina));

end_admin_panel();
?>