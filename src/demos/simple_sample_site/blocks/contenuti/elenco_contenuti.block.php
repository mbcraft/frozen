<table border="1">
    <thead>
        <td>ID</td>
        <td>Chiave</td>
        <td>Titolo</td>
        <td>Lingua</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_contenuti as $contenuto)
{
    include_block("contenuti/riga_contenuto",$contenuto);
}
?>
    </tbody>
</table>