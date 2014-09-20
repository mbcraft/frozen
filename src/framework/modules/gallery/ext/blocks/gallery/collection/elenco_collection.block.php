
<table id="tabella_elenco_collection" class="tabella_admin">
    <thead>
    <th></th>
    <th></th>
    <th>Comandi</th>
    </thead>
    <tbody>

    <?php
    foreach ($collection_list as $collection)
    {
        include_block("gallery/collection/collection_elem",$collection);
    }
    ?>
    </tbody>
</table>