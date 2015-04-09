<?

preload("AdminController");
admin_page("Gestione prodotti/servizi");

$elenco_prodotti_servizi = call("prodotto_servizio","index");

start_admin_panel("/pannello_centrale","Elenco prodotti/servizi");

include_block("prodotti_servizi/link_crea_prodotto_servizio");

include_block_if("prodotti_servizi/elenco_prodotti_servizi","prodotti_servizi/nessun_prodotto_servizio",count($elenco_prodotti_servizi)>0,array("elenco_prodotti_servizi" => $elenco_prodotti_servizi));

include_block("prodotti_servizi/link_crea_prodotto_servizio");

end_admin_panel();
?>