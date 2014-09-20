<table id="tabella_elenco_documenti" class="tabella_admin">
    <thead>
        <td>ID</td>
        <td>Nome</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_documenti as $documento)
{
    include_block("media/documenti/riga_documento",$documento);
}
?>
    </tbody>
</table>