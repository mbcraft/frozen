<?
if (!call("gallery","is_root"))
    include_block("gallery/link_to_parent_folder");
?>
<table id="tabella_elenco_elementi" class="tabella_admin">
    <thead>
        <th></th>
        <th></th>
        <th>Comandi</th>
    </thead>
    <tbody>

<?php
foreach ($elements as $elem)
{
    if ($elem["type"]=="gallery")
        include_block("gallery/dir/gallery_elem",$elem);
    if ($elem["type"]=="folder")
        include_block("gallery/dir/folder_elem",$elem);
    if ($elem["type"]=="image")
        include_block("gallery/dir/image_elem",$elem);
}
?>
    </tbody>
</table>
