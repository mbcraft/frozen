<table id="tabella_gruppi_banner" class="tabella_admin">
    <thead>
        <th>ID</th>
        <th>Nome gruppo banner</th>
        <th>Comandi</th>
    </thead>
    <tbody>
    <?
    foreach ($elenco_gruppi_banner as $gruppo_banner)
        include_block("banners/sponsor/table/__riga_gruppo_banner",$gruppo_banner);
    ?>
    </tbody>
</table>