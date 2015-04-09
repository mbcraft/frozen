<table class="tabella_admin" width="100%">
    <thead>
        <th>ID</th>
        <th>Thumbnail immagine</th>
        <th>Comandi</th>
    </thead>
    <tbody>
    <?
    foreach ($elenco_prodotti_servizi_vetrina as $prodotto_servizio_vetrina)
        include_block("vetrine/prodotti_servizi/__riga_prodotto_servizio_vetrina",$prodotto_servizio_vetrina);
    ?>
    </tbody>
</table>