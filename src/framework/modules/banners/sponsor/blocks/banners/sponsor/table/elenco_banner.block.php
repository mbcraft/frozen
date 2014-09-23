<table id="tabella_banner" class="tabella_admin">
    <thead>
        <th>ID</th>
        <th></th>
    </thead>
    <tbody>
    <?
    foreach ($elenco_banner as $banner)
        include_block("banners/sponsor/table/__riga_banner",$banner);
    ?>
    </tbody>
</table>