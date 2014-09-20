
<table id="tabella_elenco_gallery" class="tabella_admin">
    <thead>
        <th></th>
        <th></th>
        <th>Comandi</th>
    </thead>
    <tbody>

<?php
foreach ($gallery_list as $gallery)
{
    include_block("gallery/gallery/gallery_elem",$gallery);
}
?>
    </tbody>
</table>
