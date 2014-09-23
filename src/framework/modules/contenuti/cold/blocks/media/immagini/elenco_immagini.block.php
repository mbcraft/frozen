<table id="tabella_elenco_immagini" class="tabella_admin">
    <thead>
        <td>ID</td>
        <td>Nome</td>
        <td>Thumbnail</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_immagini as $immagine)
{
    include_block("media/immagini/riga_immagine",$immagine);
}
?>
    </tbody>
</table>