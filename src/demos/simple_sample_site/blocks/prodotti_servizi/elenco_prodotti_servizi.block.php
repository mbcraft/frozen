<table class="tabella_admin" width="100%">
    <thead>
        <th>ID</th>
        <th>Nome prodotto</th>
        <th>Comandi</th>
    </thead>
    <tbody>
    <?
    foreach ($elenco_prodotti_servizi as $prodotto_servizio)
        include_block("prodotti_servizi/__riga_prodotto_servizio",$prodotto_servizio);
    ?>
    </tbody>
</table>