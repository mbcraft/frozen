<table id="tabella_elenco_cartelle" class="tabella_admin">
    <thead>
        <td>ID</td>
        <td>Nome</td>
        <td>Comandi</td>
    </thead>
    <tbody>
<?php
foreach ($elenco_cartelle as $cartella)
{
    include_block("contenuti/cartelle/riga_cartella",$cartella);
}
?>
    </tbody>
</table>