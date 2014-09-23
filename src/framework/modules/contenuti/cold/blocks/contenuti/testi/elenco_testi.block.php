<table id="tabella_contenuti" class="tabella_admin">
    <thead>
        <td>ID</td>
        <td>Chiave</td>
        <td>Titolo</td>
        <td>Lingua</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_testi as $testo)
{
    include_block("contenuti/testi/riga_testo",$testo);
}
?>
    </tbody>
</table>