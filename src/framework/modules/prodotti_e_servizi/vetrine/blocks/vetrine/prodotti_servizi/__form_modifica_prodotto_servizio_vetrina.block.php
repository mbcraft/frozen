<?
/*
 * Form di modifica/creazione per il prodotto in vetrina
 * Se sono impostati id_prodotto_servizio e nome_immagine assegna i valori ai rispettivi blocchi
 * */
if (isset($id_prodotto_servizio_vetrina)) {
?>
<!-- id -->

<input type="hidden" name="id_prodotto_servizio_vetrina" value="<?=$id_prodotto_servizio_vetrina ?>" />
<?
}
?>
<!--
Script per aggiornare le immagini del prodotto/servizio selezionato
-->
<script type="text/javascript">
    function load_immagini_prodotto_servizio(source_value_id,dest_value_id)
    {
        var selected_value = $("#"+source_value_id).val();
        $("#"+dest_value_id).load('/admin/vetrine/ajax/elenco_immagini_prodotto_servizio.php',{ id_prodotto_servizio : selected_value});
    }
</script>
<input type="hidden" name="id_vetrina" value="<?=$_GET["id_vetrina"] ?>" />
Seleziona il prodotto/servizio : <br /><br />
<select id="prodotto_servizio_chooser" name="id_prodotto_servizio" onchange="load_immagini_prodotto_servizio('prodotto_servizio_chooser','elenco_immagini_chooser');">
    <?
    $elenco_prodotti_servizi = call("prodotto_servizio","index");
    foreach ($elenco_prodotti_servizi as $prodotto_servizio)
    {
        $selected_string = isset($id_prodotto_servizio) && $id_prodotto_servizio==$prodotto_servizio["id_prodotto_servizio"] ? 'selected="selected"' : "";
        echo "<option value='".$prodotto_servizio["id_prodotto_servizio"]."' ".$selected_string.">".$prodotto_servizio["nome"]."</option>";
    }
    ?>
</select>


<div id="elenco_immagini_chooser">
<?
    if (isset($id_prodotto_servizio) && isset($nome_immagine))
    {
        ?>
        <br />
        <br />
        Seleziona l'immagine da utilizzare per la vetrina :
        <br />
        <br />
        <?
        $elenco_immagini = call("prodotto_servizio","index_immagini",array("__filter_id_prodotto_servizio__EQUAL" => $id_prodotto_servizio));
        foreach ($elenco_immagini as &$img)
            if ($img["nome_immagine"]===$nome_immagine)
            {
                $img["__selected"] = true;
            }
        $params = array("elenco_oggetti" => $elenco_immagini,"blocco_presentazione" => "vetrine/prodotti_servizi/__select_immagine_prodotto_servizio");

        include_block("table/show_in_grid",$params);
    }
?>
</div>
<br />
