<div class="azioni">
    <?
    $p = isset($_GET["folder"]) ? "?folder=".$_GET["folder"] : "";
    ?>
    <a href="/admin/media/documenti/nuovo_documento.php<?=$p ?>">Carica nuovo documento</a>
</div>