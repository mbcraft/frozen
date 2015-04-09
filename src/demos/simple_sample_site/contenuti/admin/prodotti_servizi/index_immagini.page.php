<?

preload("AdminController");
admin_page("Modifica immagini");

$id_prodotto_servizio = $_GET["id_prodotto_servizio"];
$prodotto_servizio = call("prodotto_servizio","get",array("id_prodotto_servizio" => $id_prodotto_servizio));
$elenco_immagini_prodotto_servizio = call("prodotto_servizio","index_immagini",array("__filter_id_prodotto_servizio__EQUAL" => $id_prodotto_servizio));

start_admin_panel("/pannello_centrale","Modifica immagini");

?>
<table class="tabella_admin" width="100%">
    <tr>
        <td align="center">
        Modifica le immagini per il prodotto : <?=$prodotto_servizio["nome"] ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
            include_block("prodotti_servizi/link_back_to_prodotti_servizi");
            include_block("prodotti_servizi/immagini/link_carica_nuova_immagine",$this->params);
        ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
            include_block_if("prodotti_servizi/immagini/elenco_immagini","prodotti_servizi/immagini/nessuna_immagine",count($elenco_immagini_prodotto_servizio)>0,array("elenco_immagini" => $elenco_immagini_prodotto_servizio));
        ?>
        </td>
    </tr>
    <tr>
        <td>
        <?
            include_block("prodotti_servizi/link_back_to_prodotti_servizi");
            include_block("prodotti_servizi/immagini/link_carica_nuova_immagine",$this->params);
        ?>
        </td>
    </tr>
</table>

<?
end_admin_panel();
?>
