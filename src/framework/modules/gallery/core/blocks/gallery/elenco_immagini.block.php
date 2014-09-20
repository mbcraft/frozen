
<table id="tabella_elenco_immagini" class="tabella_admin">
    <thead>
    <th></th>
    <th></th>
    <th>Comandi</th>
    </thead>
    <tbody>

    <?php
    foreach ($image_list as $image)
    {
        include_block("gallery/dir/image_elem",$image);
    }
    ?>
    </tbody>
</table>