<?php

/*
 * Utilizzo dell'id folder per determinare la cartella corrente.
 * */
$immagini = call("immagini","index");

$params = array();
$params["elenco_immagini"] = $immagini;

$show_aggiungi_immagine = isset(Config::instance()->GESTIONE_CONTENUTI__IMAGE_LIMIT) && Config::instance()->GESTIONE_CONTENUTI__IMAGE_LIMIT>count($immagini);

if ($show_aggiungi_immagine)
    include_block("contenuti/immagini/link_nuova_immagine");

include_block_if("contenuti/immagini/elenco_immagini","contenuti/immagini/nessuna_immagine",count($immagini)>0,$params);

if ($show_aggiungi_immagine)
    include_block("contenuti/immagini/link_nuova_immagine");
?>


