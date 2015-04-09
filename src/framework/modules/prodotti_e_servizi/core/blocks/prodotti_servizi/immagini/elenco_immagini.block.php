Elenco delle immagini del prodotto/servizio : <br />
<br />
<br />
<table class="tabella_admin" width="100%">
    <thead>
        <th>Miniatura</th>
        <th>Nome</th>
        <th>Comandi</th>
    </thead>
    <tbody>
    <?
foreach ($elenco_immagini as $immagine)
    include_block("prodotti_servizi/immagini/__riga_immagine_prodotto_servizio",$immagine);
    ?>
    </tbody>
</table>