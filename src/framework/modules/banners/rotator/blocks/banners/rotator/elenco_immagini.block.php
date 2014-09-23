<table class="tabella_admin">
    <thead>
        <tr>
            <th>Immagine</th>
            <th>Comandi</th>
        </tr>
    </thead>
    <tbody>
    <?
        foreach($image_list as $image)
        {
            include_block("banners/rotator/__riga_immagine_rotator",array("rotator_name" => $rotator_name,"image" => $image));
        }
    ?>
    </tbody>
</table>