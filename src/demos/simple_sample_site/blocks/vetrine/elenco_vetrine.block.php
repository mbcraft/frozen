<table class="tabella_admin" width="100%">
    <thead>
        <th>
            ID
        </th>
        <th>
            Nome vetrina
        </th>
        <th>
            Comandi
        </th>
    </thead>
    <tbody>
    <?
    foreach ($elenco_vetrine as $vetrina)
        include_block("vetrine/__riga_vetrina",$vetrina);
    ?>
    </tbody>
</table>