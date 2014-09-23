<table id="tabella_elenco_documenti" class="tabella_admin">
    <thead>
        <td>ID</td>
        <td>Chiave</td>
        <td>Nome</td>
        <td>Lingua</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_documenti as $documento)
{
    include_block("contenuti/documenti/riga_documento",$documento);
}
?>
    </tbody>
</table>