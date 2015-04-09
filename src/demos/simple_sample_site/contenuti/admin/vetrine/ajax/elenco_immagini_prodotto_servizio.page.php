<br />
<br />
Seleziona l'immagine da utilizzare per la vetrina :
<br />
<br />
<?

$id_prodotto_servizio = Params::get("id_prodotto_servizio");

$elenco_immagini = call("prodotto_servizio","index_immagini",array("__filter_id_prodotto_servizio__EQUAL" => $id_prodotto_servizio));

$params = array("elenco_oggetti" => $elenco_immagini,"blocco_presentazione" => "vetrine/prodotti_servizi/__select_immagine_prodotto_servizio");

include_block("table/show_in_grid",$params)

?>